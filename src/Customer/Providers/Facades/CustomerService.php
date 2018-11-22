<?php

namespace Zento\Customer\Providers\Facades;

class CustomerService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'CustomerService';
    }
}
