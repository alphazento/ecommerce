<?php
namespace Zento\BladeTheme\Services\Concerns;

use Illuminate\Support\Arr;
use Zento\BladeTheme\View\ViewCache;
use Zento\BladeTheme\View\ViewCollection;

trait TraitBladeDirective
{
    /**
     * @var ViewCollection
     */
    protected $viewCollection;

    public function __construct()
    {
        $this->viewCollection = new ViewCollection();
    }

    public function removeView($viewName)
    {
        $this->viewCollection->addToDelete($viewName);
        return $this;
    }

    public function replaceView($viewName, $replaceAs)
    {
        $this->viewCollection->addToReplace($viewName, $replaceAs);
        return $this;
    }

    public function isViewDeleted($viewName)
    {
        return $this->viewCollection->isDeleted($viewName);
    }

    public function isViewReplaced($viewName)
    {
        return $this->viewCollection->isReplaced($viewName);
    }

    public function renderCachedView($env, $vars, $cacheKey, $view, $data = [])
    {
        $cacheview = new ViewCache($cacheKey, $env->make($view, $data, Arr::except($vars, ['__data', '__path'])));
        return $cacheview->render();
    }
}
