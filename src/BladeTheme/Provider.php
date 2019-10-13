<?php

namespace Zento\BladeTheme;

use Illuminate\Support\ServiceProvider;
use Zento\BladeTheme\View\DirectiveExtend;
use Zento\BladeTheme\View\Factory as ViewFactory;
use Zento\BladeTheme\View\Processer\BladeViewEnhance;
use Zento\BladeTheme\Services\BladeTheme;

class Provider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('view', function($app) {
            $factory = new ViewFactory($app);
            (new DirectiveExtend())->inject($factory);
            return $factory->addViewProcessor(new BladeViewEnhance());
        });

        $this->app->singleton('bladetheme', function ($app) {
            return new BladeTheme();
        });
    }
}
