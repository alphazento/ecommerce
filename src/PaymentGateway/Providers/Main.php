<?php

namespace Zento\PaymentGateway\Providers;

use Zento\Kernel\Facades\PackageManager;
use Zento\PaymentGateway\Services\PaymentGateway;
use Illuminate\Support\ServiceProvider;

class Main extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('payment_gateway', function ($app) {
            return new PaymentGateway($app);
        });

        PackageManager::class_alias('\Zento\PaymentGateway\Providers\Facades\PaymentGateway', 'PaymentGateway');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['payment_gateway'];
    }
}
