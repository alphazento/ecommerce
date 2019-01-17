<?php

namespace Zento\Catalog\Providers;

use Zento\Catalog\Services\CatalogService;
use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\ProductService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

use ThemeManager;

use Zento\Kernel\Facades\PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('catalog_service', function ($app) {
            return new CatalogService();
        });

        $this->app->singleton('category_service', function ($app) {
            return new CategoryService();
        });

        $this->app->singleton('product_service', function ($app) {
            return new ProductService();
        });
        
        PackageManager::class_alias('\Zento\Catalog\Providers\Facades\CatalogService', 'CatalogService');
        PackageManager::class_alias('\Zento\Catalog\Providers\Facades\CategoryService', 'CategoryService');
        PackageManager::class_alias('\Zento\Catalog\Providers\Facades\ProductService', 'ProductService');

        if (!$this->app->runningInConsole()) {
            // ThemeManager::prependUserThemeLocation(PackageManager::packageViewsPath('Zento_MainTheme'));
        }
        $this->app['catalog_service']->registerFilterLayer(function($builder) {
            $builder->where('visibility', '!=', 1);
        });
    }

    public function boot() {
        if (!$this->app->runningInConsole()) {
            $this->app->booted(function ($app) {
                $app['routeandrewriter_svc']->appendRewriteEngine(new \Zento\Catalog\Model\CategoryUrlRewriteEngine());
                $app['routeandrewriter_svc']->appendRewriteEngine(new \Zento\Catalog\Model\ProductUrlRewriteEngine());
            });
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['CatalogService', 'CategoryService', 'ProductService'];
    }
}
