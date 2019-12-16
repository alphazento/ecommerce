<?php
namespace Zento\BladeTheme\Services\Concerns;

use View;
use Closure;

trait TraitViewData {
    protected $globalViewData = [];
    protected $preRouteCallActions = [];

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
