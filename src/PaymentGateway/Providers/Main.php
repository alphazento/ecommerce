<?php

namespace Zento\PaymentGateway\Providers;

use Zento\PaymentGateway\Services\PaymentGateway;
use Illuminate\Support\ServiceProvider;

class Main extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('paymentgateway', function ($app) {
            return new PaymentGateway($app);
        });

        $this->app->alias('\Zento\PaymentGateway\Providers\Facades\PaymentGateway', 'PaymentGateway');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['paymentgateway'];
    }
}
