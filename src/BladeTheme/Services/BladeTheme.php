<?php
namespace Zento\BladeTheme\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Str;

use View;
use Route;
use Request;
use Closure;
use ShareBucket;

use Zento\BladeTheme\View\ViewCache;
use Zento\BladeTheme\View\ViewCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;

class BladeTheme {
    use Macroable;

    /**
     * @var ViewCollection
     */
    protected $viewCollection;

    protected $stubProcessors = [];
    protected $breadcrumbData = [];

    protected $globalViewData = [];

    protected $preRouteCallActions = [];

    public function __construct() {
        $this->viewCollection = new ViewCollection();
    }

    public function __toString() {
        return json_encode($this->breadcrumbData, JSON_PRETTY_PRINT);
    }

    public function apiUrl($path) {
        return sprintf('/api/v1/%s', $path);
    }

    public function removeView($viewName) {
        $this->viewCollection->addToDelete($viewName);
        return $this;
    }

    public function replaceView($viewName, $replaceAs) {
        $this->viewCollection->addToReplace($viewName, $replaceAs);
        return $this;
    }

    public function isViewDeleted($viewName) {
        return $this->viewCollection->isDeleted($viewName);
    }

    public function isViewReplaced($viewName) {
        return $this->viewCollection->isReplaced($viewName);
    }

    public function appendStubProcessor(Closure $callback) {
        $this->stubProcessors[] = $callback;
    }

    public function processStub($name, $data) {
        foreach($this->stubProcessors ?? [] as $callback) {
            $callback($name, $data);
        }
    }

    public function breadcrumb($url, $title) {
        $this->breadcrumbData[] = compact('url', 'title');
        return $this;
    }

    public function getBreadcrumb() {
        return $this->breadcrumbData;
    }

    public function renderCachedView($env, $vars, $cacheKey, $view, $data = []) {
        $cacheview = new ViewCache($cacheKey, $env->make($view, $data, Arr::except($vars, ['__data', '__path'])));
        return $cacheview->render();
    }

    public function view($view, $data = null) {
        if ($data) {
            $this->addGlobalViewData($data);
        }
        count($this->globalViewData) && View::share($this->globalViewData);
        return view($view, $this->globalViewData);
    }

    public function noLocalCacheView($view, $data =null, $headers = []) {
        $data && View::share($data);
        return response()
            ->view($view)
            ->header("Cache-Control",
                "no-cache, max-age=0, must-revalidate, no-store");
    }

    public function requestInnerApi($method, $url, $data = [], $headers = []) : \Zento\Kernel\Http\ApiResponse {
        //keep origin stack
        $originRequest = Request::instance();
        $originRoute = Route::current();

        //inner request disable middleware
        app()->instance('middleware.disable', true);

        //prepare new request instance
        $request = Request::create($url, $method, $data);
        if ($token = $this->globalViewData['apiGuestToken'] ?? false) {
            $request->headers->add(['authorization' => $token]);
        }
        if (count($headers)) {
            $request->headers->add($headers);
        }
        app()->instance('request', $request);
        
        ShareBucket::put(\Zento\Passport\Http\Middleware\GuestToken::ALLOW_GUEST_API, true);
        $resp = Route::dispatch($request)->getOriginalContent();

        //restore to origin stack
        app()->instance('request', $originRequest);
        Route::setCurrent($originRoute);
        
        return $resp->getApiResponse();
    }

    public function addGlobalViewData(array $data) {
        $this->globalViewData = array_merge_recursive($this->globalViewData, $data);
        return $this;
    }

    public function getGlobalViewData($key) {
        return $this->globalViewData[$key] ?? null;
    }

    public function shareViewData() {
        View::share($this->globalViewData);
        return $this;
    }

    /**
     * call before theme route action is called.
     *
     * @return void
     */
    public function preRouteCallAction() {
        foreach($this->preRouteCallActions as $callback) {
            $callback($this);
        }
        return $this;
    }

    /**
     * @param \Closure|null $callback
     * @return void
     */
    public function registerPreRouteCallAction(\Closure $callback) {
        $this->preRouteCallActions[] = $callback;
        return $this;
    }
}
