<?php

namespace Zento\EWayPayment;

use Zento\Kernel\Facades\PackageManager;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Illuminate\Support\ServiceProvider;
use Zento\EWayPayment\Services\PaymentMethod;

class Provider extends ServiceProvider
{
    public function boot()
    {
        PaymentGateway::registerMethod("ewaypayment", function() {
            return new PaymentMethod();
        });
    }
}
