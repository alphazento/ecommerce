<?php

namespace Zento\Acl\Providers;

use Request;
use Route;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

use Zento\Passport\Passport;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Acl\Exceptions\AclException;

class Entry extends ServiceProvider
{
    public function register() {
        $this->app->singleton('acl', function ($app) {
            return new \Zento\Acl\Services\Acl();
        });

        $this->app->singleton('Illuminate\Contracts\Debug\ExceptionHandler',
            '\Zento\Acl\Exceptions\ExceptionHandler');

        Passport::registerPostAuthcateHook(function($user, $request) {
            if (!Acl::checkRequest($request, $user)) {
                // throw new AclException();
            }
        });

        if ($this->app->runningInConsole()) {
            \Illuminate\Routing\Route::mixin(new \Zento\Acl\Mixins\Routing\Route);
            (new \Zento\Acl\Console\PackageEnableSubscriber())->subscribe();
        }
    }
}
