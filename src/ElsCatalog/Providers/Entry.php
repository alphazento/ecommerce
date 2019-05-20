<?php

namespace Zento\ElsCatalog\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\ElsCatalog\Services\CatalogSearchService;
use Zento\Kernel\Facades\PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('catalogsearch_service', function ($app) {
            return new CatalogSearchService();
        });
    }
}
