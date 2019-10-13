<?php
namespace Zento\BladeTheme\Services;

use Illuminate\Container\Container;
use Illuminate\Support\Str;

use Closure;
use Illuminate\Support\Arr;
use Zento\BladeTheme\View\ViewCache;
use Zento\BladeTheme\View\ViewCollection;

class BladeTheme {
    /**
     * @var ViewCollection
     */
    protected $viewCollection;

    protected $stubProcessors = [];
    protected $breadcrumbData = ['tree' => []];

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

    public function breadcrumb($url, $name, $isExtraData = false) {
        if (empty($this->breadcrumbData['tree'])) {
            $this->breadcrumbData['tree'] = [['url'=>route('home'), 'name'=>'Home' ]];
        }
        if ($isExtraData) {
            $this->breadcrumbData[$url] = $name;
        } else {
            $this->breadcrumbData['tree'][] = compact('url', 'name');
        }
        return $this;
    }

    public function renderBreadcrumb($view = 'components.breadcrumb') {
        if (!empty($this->breadcrumbData['tree'])) {
            return view($view, $this->breadcrumbData)->render();
        } else {
            return '';
        }
    }

    public function renderCachedView($env, $vars, $cacheKey, $view, $data = []) {
        $cacheview = new ViewCache($cacheKey, $env->make($view, $data, Arr::except($vars, ['__data', '__path'])));
        return $cacheview->render();
    }

    public function view($view, $data = []) {
        View::share($data);
        return view($view);
    }

    public function noLocalCacheView($view, $data =[], $headers = []) {
        View::share($data);
        return response()
            ->view($view)
            ->header("Cache-Control",
                "no-cache, max-age=0, must-revalidate, no-store");
    }
}
