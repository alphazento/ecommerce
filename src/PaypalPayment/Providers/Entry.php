<?php

namespace Zento\PaypalPayment\Providers;

use Zento\Kernel\Facades\PackageManager;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Illuminate\Support\ServiceProvider;
use Zento\PaypalPayment\Services\PaymentMethod;

class Entry extends ServiceProvider
{
    public function register()
    {
        PaymentGateway::registerMethod("paypalexpress", function() {
            return new PaymentMethod();
        });
    }
}
