<?php

namespace Zento\HelloSns\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\HelloSns\Services\HelloSnsService;

class Plugin extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            $service = (new HelloSnsService())->prepareServices();
            $this->app->singleton('hellosns_service', function($app) use($service) {
                return $service;
            });
        }
    }
}
