<?php
namespace Zento\BladeTheme\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Str;

use View;
use Route;
use Request;
use Closure;
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

    public function __construct() {
        $this->viewCollection = new ViewCollection();
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
        $data && View::share($data);
        return view($view);
    }

    public function noLocalCacheView($view, $data =null, $headers = []) {
        $data && View::share($data);
        return response()
            ->view($view)
            ->header("Cache-Control",
                "no-cache, max-age=0, must-revalidate, no-store");
    }

    public function innerApiProxy($method, $url, $data = []) {
        $originRequest = Request::instance();
        app()->instance('middleware.disable', true);

        $request = Request::create($url, $method, $data);
        
        app()->instance('request', $request);
        $resp = Route::dispatch($request);
        $respData = $resp->getOriginalContent();
        app()->instance('request', $originRequest);
        return $respData;
    }
}
