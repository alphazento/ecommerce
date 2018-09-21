<?php

namespace Zento\Catalog\Providers;

use Zento\Catalog\Services\Category;
use Zento\Catalog\Services\Product;

use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('category', function ($app) {
            return new Category();
        });

        $this->app->singleton('product', function ($app) {
            return new Product();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['category', 'product'];
    }
}
