<?php

namespace Zento\Backend\Providers;

use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register() {
        $this->app->singleton('admin', function ($app) {
            return new \Zento\Backend\Services\AdminService();
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