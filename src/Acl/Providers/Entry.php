<?php

namespace Zento\Acl\Providers;

use Request;
use Route;
use Auth;

use Zento\Passport\Passport;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Acl\Exceptions\AclException;
use Zento\Acl\Policies\DashboardUxPolicy;
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
        $this->app->singleton('acl', function ($app) {
            return new \Zento\Acl\Services\Acl();
        });

        $this->app->singleton('Illuminate\Contracts\Debug\ExceptionHandler',
            '\Zento\Acl\Exceptions\ExceptionHandler');

        Passport::registerPostAuthcateHook(function($user, $request) {
            if (!Acl::checkRequest($request, $user)) {
                throw new AclException();
            }
        });

        if ($this->app->runningInConsole()) {
            \Illuminate\Routing\Route::mixin(new \Zento\Acl\Mixins\Routing\Route);
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
