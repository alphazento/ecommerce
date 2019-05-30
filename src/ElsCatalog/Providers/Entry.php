<?php

namespace Zento\ElsCatalog\Providers;

use ShareBucket;

use Zento\ElsCatalog\Services\CatalogSearchService;
use Zento\CatalogSearch\Services\CatalogSearchService as ORMCatalogSearchService;
use Zento\Catalog\Services\CategoryService as ORMCategoryService;
use Zento\ElsCatalog\Services\CategoryService;
use Zento\Kernel\Facades\PackageManager;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('category_service', function ($app) {
            switch (ShareBucket::get('app_portal', 'frontend')) {
                case 'admin':
                    return new ORMCategoryService();
                    break;
                case 'frontend':
                    return new CategoryService();
                    break;
            }
        });

        $this->app->singleton('catalogsearch_service', function ($service, $app) {
            switch (ShareBucket::get('app_portal', 'frontend')) {
                case 'admin':
                    return new ORMCatalogSearchService();
                    break;
                case 'frontend':
                    return new CatalogSearchService();
                    break;
            }
        });
    }
}
