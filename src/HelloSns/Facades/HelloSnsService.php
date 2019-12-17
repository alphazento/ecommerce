<?php

namespace Zento\HelloSns\Facades;

class HelloSnsService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'hellosns_service';
    }
}
