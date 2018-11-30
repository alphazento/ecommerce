<?php

namespace Zento\FreeShipping\Providers;

use Zento\Catalog\Services\Product;
use Zento\Shipment\Providers\Facades\ShipmentService;
use Zento\FreeShipping\Model\ShippingMethod;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function boot()
    {
        ShipmentService::registerMethod(ShippingMethod::CODE, new ShippingMethod());
    }
}
