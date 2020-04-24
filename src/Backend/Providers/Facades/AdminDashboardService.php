<?php

namespace Zento\Backend\Providers\Facades;

class AdminDashboardService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'admin_dashboard_sevice';
    }
}