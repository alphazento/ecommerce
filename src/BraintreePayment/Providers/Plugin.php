<?php

namespace Zento\BraintreePayment\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\BraintreePayment\Services\PaymentMethod;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;

class Plugin extends ServiceProvider
{
    public function boot()
    {
        PaymentGateway::registerMethod("braintree", function () {
            return new PaymentMethod();
        });
    }
}
