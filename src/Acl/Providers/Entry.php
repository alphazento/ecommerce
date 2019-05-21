<?php

namespace Zento\Acl\Providers;

use Request;
use Route;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

use Zento\Acl\Model\Auth\UserProvider;

class Entry extends ServiceProvider
{
    public function register() {
        $this->app->singleton('acl', function ($app) {
            return new \Zento\Acl\Services\APC();
        });
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('admin_users', function()
        {
            return new UserProvider();
        });
    }
}
