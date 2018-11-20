<?php

namespace Zento\Sales\Providers;

// use Zento\Catalog\Services\CategoryService;
use Zento\Catalog\Services\Product;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('SalesService', function ($app) {
            return new \Zento\Sales\Services\SalesService();
        });
       
        class_alias('\Zento\Sales\Providers\Facades\SalesService', 'SalesService');
    }
}
