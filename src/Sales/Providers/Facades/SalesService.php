<?php

namespace Zento\Sales\Providers\Facades;

class SalesService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sales_service';
    }
}
