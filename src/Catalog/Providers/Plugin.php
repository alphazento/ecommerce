<?php

namespace Zento\Catalog\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\ProductService;
use Zento\Kernel\Facades\PackageManager;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('category_service', function ($app) {
            return new CategoryService();
        });

        $this->app->singleton('product_service', function ($app) {
            return new ProductService();
        });

        PackageManager::class_alias('\Zento\Catalog\Providers\Facades\CategoryService', 'CategoryService');
        PackageManager::class_alias('\Zento\Catalog\Providers\Facades\ProductService', 'ProductService');
    }

    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            $this->app->booted(function ($app) {
                $rewriteSvc = $app['routeandrewriter_svc'];
                $rewriteSvc->appendRewriteEngine(new \Zento\Catalog\Model\CategoryUrlRewriteEngine());
                $rewriteSvc->appendRewriteEngine(new \Zento\Catalog\Model\ProductUrlRewriteEngine());

                //uri builder for web
                $rewriteSvc->setUriBuilder('category', function ($id) {
                    return sprintf('/categories/%s', $id);
                });
                $rewriteSvc->setUriBuilder('product', function ($id) {
                    // return route('product', ['id' => $id]);
                    return sprintf('/products/%s', $id);
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
        return ['CategoryService', 'ProductService'];
    }
}
