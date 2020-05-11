<?php

namespace Zento\Sales\Providers;

// use Zento\Catalog\Services\CategoryService;
use Illuminate\Support\ServiceProvider;
use Zento\Kernel\Facades\PackageManager;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('sales_service', function ($app) {
            return new \Zento\Sales\Services\SalesService();
        });

        PackageManager::class_alias('\Zento\Sales\Providers\Facades\SalesService', 'SalesService');
    }
}
