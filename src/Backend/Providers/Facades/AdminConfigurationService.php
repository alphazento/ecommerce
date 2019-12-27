<?php

namespace Zento\Backend\Providers\Facades;

class AdminConfigurationService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin_configuration_sevice';
    }
}