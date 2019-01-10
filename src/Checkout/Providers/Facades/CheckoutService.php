<?php

namespace Zento\Checkout\Providers\Facades;

class CheckoutService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CheckoutService';
    }
}
