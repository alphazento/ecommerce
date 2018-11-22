<?php

namespace Zento\Customer\Providers;

// use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CustomerService', function ($app) {
            return new \Zento\Customer\Services\CustomerService();
        });
       
        class_alias('\Zento\Customer\Providers\Facades\CustomerService', 'CustomerService');
    }
}
