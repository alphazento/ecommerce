<?php

namespace Zento\EWayPayment\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\EWayPayment\Services\PaymentMethod;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;

class Plugin extends ServiceProvider
{
    public function boot()
    {
        PaymentGateway::registerMethod("ewaypayment", function () {
            return new PaymentMethod();
        });
    }
}
