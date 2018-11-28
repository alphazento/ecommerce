<?php

namespace Zento\Customer\Providers;

// use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;
use Zento\Kernel\Facades\PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('customer_service', function ($app) {
            return new \Zento\Customer\Services\CustomerService();
        });
       
        PackageManager::class_alias('\Zento\Customer\Providers\Facades\CustomerService', 'CustomerService');
    }
}
