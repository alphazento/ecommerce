<?php

namespace Zento\Backend\Providers;

use Zento\Backend\Policies\DashboardUxPolicy;
use Zento\Backend\Services\AdminDashboardService;

use Illuminate\Support\Str;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class Entry extends AuthServiceProvider
{
    /**
    * The policy mappings for the application.
    *
    * @var array
    */
   protected $policies = [
       AdminDashboardService::class => DashboardUxPolicy::class,
   ];

    public function register() {
        $this->app->singleton('admin_dashboard_sevice', function ($app) {
            return new \Zento\Backend\Services\AdminDashboardService();
        });

        $this->app->singleton('admin_configuration_sevice', function ($app) {
            return new \Zento\Backend\Services\AdminConfigurationService();
        });
    }

    /**
     * Register any application authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}