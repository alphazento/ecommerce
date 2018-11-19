<?php

namespace Zento\Shipment\Providers;

use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('ShipmentService', function ($app) {
            return new \Zento\Shipment\Services\ShipmentService();
        });
       
        class_alias('\Zento\Shipment\Providers\Facades\ShipmentService', 'ShipmentService');
    }
}
