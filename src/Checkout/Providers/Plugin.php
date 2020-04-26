<?php

namespace Zento\Checkout\Providers;

use Zento\Checkout\Services\CheckoutService;
use Illuminate\Support\ServiceProvider;
use PackageManager;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CheckoutService', function ($app) {
            return new CheckoutService();
        });

        PackageManager::class_alias('\Zento\Checkout\Providers\Facades\CheckoutService', 'CheckoutService');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['CheckoutService'];
    }
}
