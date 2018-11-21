<?php

namespace Zento\Admin\Providers;

use Store;
use Request;
use Route;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

use Zento\Admin\Model\Auth\SessionGuard;
use Zento\Admin\Model\Auth\UserProvider;

class Entry extends ServiceProvider
{
    public function register() {
        $this->app->singleton('admin', function ($app) {
            return new \Zento\Admin\Services\Admin();
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('adminauth', function ($app) {
            $guard = new SessionGuard(
                'adminauth',
                new UserProvider(),
                $app->make('session.store'),
                $this->app->request
            );

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($this->app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($this->app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($this->app->refresh('request', $guard, 'setRequest'));
            }
            return $guard;
        });
    }
}