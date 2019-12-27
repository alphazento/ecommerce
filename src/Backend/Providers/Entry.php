<?php

namespace Zento\Backend\Providers;


use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register() {
        $this->app->singleton('admin_dashboard_sevice', function ($app) {
            return new \Zento\Backend\Services\AdminDashboardService();
        });

        $this->app->singleton('admin_configuration_sevice', function ($app) {
            return new \Zento\Backend\Services\AdminConfigurationService();
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
       
    }
}