<?php

namespace Zento\Shipment\Providers\Facades;

class ShipmentService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shipment_service';
    }
}
