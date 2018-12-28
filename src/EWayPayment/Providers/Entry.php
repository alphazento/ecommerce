<?php

namespace Zento\EWayPayment\Providers;

use Zento\Kernel\Facades\PackageManager;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Illuminate\Support\ServiceProvider;
use Zento\PaymentGateway\Services\PaymentMethod;

class Entry extends ServiceProvider
{
    public function register()
    {
        PaymentGateway::registerMethod("ewaypayment", function() {
            return new PaymentMethod();
        });
    }
}
