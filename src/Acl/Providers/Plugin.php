<?php

namespace Zento\Acl\Providers;

use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Zento\Acl\Policies\ApiAccessControlPolicy;
use Zento\Acl\Policies\DashboardUxPolicy;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Backend\Services\AdminDashboardService;

class Plugin extends AuthServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        AdminDashboardService::class => DashboardUxPolicy::class,
        Request::class => ApiAccessControlPolicy::class,
    ];

    public function register()
    {
        $this->app->singleton('acl', function ($app) {
            return new \Zento\Acl\Services\Acl();
        });

        $this->app->singleton('Illuminate\Contracts\Debug\ExceptionHandler',
            '\Zento\Acl\Exceptions\ExceptionHandler');

        if ($this->app->runningInConsole()) {
            // Route::mixin(new \Zento\Acl\Mixins\Routing\Route);
            (new \Zento\Acl\Console\PackageEnableSubscriber())->subscribe();
        }
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
