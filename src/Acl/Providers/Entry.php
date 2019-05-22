<?php

namespace Zento\Acl\Providers;

use Request;
use Route;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

use Zento\Acl\Model\Auth\UserProvider;
use Zento\Passport\Passport;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Acl\AclException;

class Entry extends ServiceProvider
{
    public function register() {
        \Zento\Customer\Http\Middleware\UseCustomerModel::$Model = \Zento\Acl\Model\Auth\Customer::class;
        $this->app->singleton('acl', function ($app) {
            return new \Zento\Acl\Services\Acl();
        });

        Passport::registerPostAuthcateHook(function($user, $request) {
            if (!Acl::checkRequest($request, $user)) {
                throw new AclException();
            }
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Auth::provider('admin_users', function()
        // {
        //     return new UserProvider();
        // });
    }
}
