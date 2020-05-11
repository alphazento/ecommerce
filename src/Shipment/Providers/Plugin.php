<?php

namespace Zento\Shipment\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\Kernel\Facades\PackageManager;

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
