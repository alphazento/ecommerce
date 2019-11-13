<?php

namespace Zento\VueDesktopTheme;

use Zento\Kernel\Facades\ThemeManager;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function register()
    {
        ThemeManager::whenSetTheme('Zento_VueDesktopTheme', function($app) {
            \Zento\BladeTheme\Http\Controllers\CatalogController::$OverwriteBy = '\Zento\VueDesktopTheme\Http\Controllers\ThemeController';
            \Zento\BladeTheme\Http\Controllers\GeneralController::$OverwriteBy = '\Zento\VueDesktopTheme\Http\Controllers\GeneralController';
            // $this->app->singleton('Zento\BladeTheme\Http\Controllers\CatalogController', function() {
            //     return new \Zento\VueDesktopTheme\Http\Controllers\ThemeController;
            // });
            \Zento\BladeTheme\Services\BladeTheme::mixin(new \Baicy\DesktopTheme\Mixins\BladeTheme);
        });
    }
}
