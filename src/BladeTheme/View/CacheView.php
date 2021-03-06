<?php
namespace Zento\BladeTheme\View;

use Cache;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Zento\BladeTheme\Consts;

class CacheView implements View
{
    private $key;
    private $view;
    private $data;

    public function __construct($key, $view, $data = [])
    {
        $this->key = sprintf('viewcache.%s.%s', $view->name(), $key);
        $this->view = $view;
        $this->data = $data;
    }

    public function name()
    {
        return $this->view->name();
    }

    public function render()
    {
        $content = '';
        if (Cache::store('viewcache')->has($this->key)) {
            $content = Cache::store('fullpageview')->get($this->key);
        } else {
            $content = $this->view->render();
            Cache::store('viewcache')->put($this->key, $content, Carbon::now()->addHours(config(Consts::CACHE_KEY_BLADE_VIEW_EXPIRE, 12)));
        }
        return $content;
    }

    public function with($key, $value = null)
    {
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
}
