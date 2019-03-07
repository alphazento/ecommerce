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
        $this->app['catalog_service']->registerCriteriaFilter('visibility',
            function ($builder, $value) {
                if (empty($value) || $value === 'storefront') {
                    $builder->where('visibility', '>', 1);
                } else {
                    if ($value !== 'admin') {
                        if (!is_array($value)) {
                            $value = [$value];
                        }
                        $builder->whereIn('visibility', $value);
                    }
                }
            }
        );
    }

    public function boot() {
        if (!$this->app->runningInConsole()) {
            $this->app->booted(function ($app) {
                $rewriteSvc = $app['routeandrewriter_svc'];
                $rewriteSvc->appendRewriteEngine(new \Zento\Catalog\Model\CategoryUrlRewriteEngine());
                $rewriteSvc->appendRewriteEngine(new \Zento\Catalog\Model\ProductUrlRewriteEngine());

                //uri builder for web
                $rewriteSvc->setUriBuilder('category', function($id) {
                    // return route('category', ['ids' => $id]);
                    return sprintf('/category/%s', $id);
                });
                $rewriteSvc->setUriBuilder('product', function($id) {
                    // return route('product', ['id' => $id]);
                    return sprintf('/product/%s', $id);
                });
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
