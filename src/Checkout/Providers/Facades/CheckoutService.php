<?php

namespace Zento\ShoppingCart\Providers\Facades;

class ShoppingCartService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ShoppingCartService';
    }
}
