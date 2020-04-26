<?php

namespace Zento\Customer\Providers;

// use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;
use Zento\Kernel\Facades\PackageManager;

class Plugin extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('customer_service', function ($app) {
            return new \Zento\Customer\Services\CustomerService();
        });
       
        $this->app->bind('\Zento\Passport\Model\PassportGuestUser', '\Zento\Customer\Model\ApiGuestUser');
       
        PackageManager::class_alias('\Zento\Customer\Providers\Facades\CustomerService', 'CustomerService');
    }
}
