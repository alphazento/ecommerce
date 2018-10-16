<?php

namespace Zento\Catalog\Providers;

use Zento\Catalog\Services\EloquentCategoryProvider;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

use ThemeManager;
use PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('categoryservice', function ($app) {
            return new EloquentCategoryProvider('\Zento\Catalog\Model\ORM\Category');
        });

        $this->app->singleton('product', function ($app) {
            return new Product();
        });
        
        class_alias('\Zento\Catalog\Providers\Facades\CategoryService', 'CategoryService');
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
        return ['categoryservice', 'product'];
    }
}
