<?php

namespace Zento\ShoppingCart\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\Kernel\Facades\PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('shppcart_service', function ($app) {
            return new \Zento\ShoppingCart\Services\ShoppingCartService();
        });
        PackageManager::class_alias('\Zento\ShoppingCart\Providers\Facades\ShoppingCartService', 'ShoppingCartService');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['shppcart_service'];
    }
}
