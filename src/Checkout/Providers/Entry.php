<?php

namespace Zento\Checkout\Providers;

use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        // $this->app->singleton('ShoppingCartService', function ($app) {
        //     return new \Zento\ShoppingCart\Services\ShoppingCartService();
        // });
       
        // class_alias('\Zento\ShoppingCart\Providers\Facades\ShoppingCartService', 'ShoppingCartService');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    // public function provides()
    // {
    //     return ['categoryservice', 'product'];
    // }
}
