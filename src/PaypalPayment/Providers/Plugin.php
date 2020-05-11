<?php

namespace Zento\PaypalPayment\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Zento\PaypalPayment\Services\PaymentMethod;

class Plugin extends ServiceProvider
{
    public function boot()
    {
        PaymentGateway::registerMethod("paypalexpress", function () {
            return new PaymentMethod();
        });
    }
}
