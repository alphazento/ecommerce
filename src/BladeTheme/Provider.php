<?php

namespace Zento\BladeTheme;

use Illuminate\Support\ServiceProvider;
use Zento\BladeTheme\View\DirectiveExtend;
use Zento\BladeTheme\View\Factory as ViewFactory;
use Zento\BladeTheme\View\Processer\BladeViewEnhance;
use Zento\BladeTheme\Services\BladeTheme;
use Zento\Kernel\Facades\PackageManager;
use Zento\Kernel\Facades\ThemeManager;

class Provider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('bladetheme', function ($app) {
            return new BladeTheme();
        });

        PackageManager::class_alias('\Zento\BladeTheme\Facades\BladeTheme', 'BladeTheme');

        if (!$this->app->runningInConsole()) {
            $this->app->singleton('view', function($app) {
                $paths = ThemeManager::getViewPaths();
                $factory = new ViewFactory($app);
                $factory->getFinder()->setPaths($paths);
                ThemeManager::changeViewFactory($factory);
                (new DirectiveExtend())->inject($factory);
                return $factory->addViewProcessor(new BladeViewEnhance());
            });
            $this->app->bind('App\Http\Controllers\Auth\LoginController', '\Zento\BladeTheme\Http\Controllers\Auth\LoginController');
            $this->app->bind('App\Http\Controllers\Auth\RegisterController', '\Zento\BladeTheme\Http\Controllers\Auth\RegisterController');
            $this->app->bind('App\Http\Controllers\Auth\ForgotPasswordController', '\Zento\BladeTheme\Http\Controllers\Auth\ForgotPasswordController');
        }
       
        \Illuminate\Routing\Router::mixin(new \Zento\BladeTheme\Http\Mixins\Router);
    }
}
