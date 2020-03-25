<?php

namespace Zento\ElsCatalog\Providers;

use ShareBucket;

use Zento\CatalogSearch\Services\CatalogSearchService as ORMCatalogSearchService;
use Zento\Catalog\Services\CategoryService as ORMCategoryService;
use Zento\ElsCatalog\Services\CategoryService  as ElsCategoryService;
use Zento\ElsCatalog\Services\CatalogSearchService as ElsCatalogSearchService;
use Zento\Kernel\Facades\PackageManager;
use Illuminate\Support\ServiceProvider;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('category_service', function ($app) {
            switch (ShareBucket::get('app_portal', 'front-end')) {
                case 'admin':
                    return new ORMCategoryService();
                    break;
                case 'front-end':
                    return new ElsCategoryService();
                    break;
            }
        });

        $this->app->singleton('catalogsearch_service', function ($service, $app) {
            switch (ShareBucket::get('app_portal', 'front-end')) {
                case 'admin':
                    return new ORMCatalogSearchService();
                    break;
                case 'front-end':
                    return new ElsCatalogSearchService();
                    break;
            }
        });
    }
}
