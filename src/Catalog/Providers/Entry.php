<?php

namespace Zento\Catalog\Providers;

use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

use ThemeManager;
use PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CategoryService', function ($app) {
            return new CategoryService();
        });

        $this->app->singleton('ProductService', function ($app) {
            return new ProductService();
        });
        
        class_alias('\Zento\Catalog\Providers\Facades\CategoryService', 'CategoryService');
        class_alias('\Zento\Catalog\Providers\Facades\ProductService', 'ProductService');

        if (!$this->app->runningInConsole()) {
            ThemeManager::prependUserThemeLocation(PackageManager::packageViewsPath('Zento_MainTheme'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['CategoryService', 'ProductService'];
    }
}
