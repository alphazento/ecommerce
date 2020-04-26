<?php

namespace Zento\Shipment\Providers;

use Zento\Kernel\Facades\PackageManager;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('shipment_service', function ($app) {
            return new \Zento\Shipment\Services\ShipmentService();
        });
       
        PackageManager::class_alias('\Zento\Shipment\Providers\Facades\ShipmentService', 'ShipmentService');
    }
}
