<?php

namespace Zento\HelloSns;

use Illuminate\Support\ServiceProvider;
use Zento\BladeTheme\Facades\BladeTheme;
use Zento\HelloSns\Services\HelloSnsService;

class Provider extends ServiceProvider
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
