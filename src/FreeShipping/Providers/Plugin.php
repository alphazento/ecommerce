<?php

namespace Zento\FreeShipping\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\FreeShipping\Model\ShippingMethod;
use Zento\Shipment\Providers\Facades\ShipmentService;

class Plugin extends ServiceProvider
{
    public function boot()
    {
        ShipmentService::registerMethod(ShippingMethod::CODE, new ShippingMethod());
    }
}
