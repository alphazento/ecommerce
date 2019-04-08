<?php

namespace Zento\CatalogSearch\Providers;

use Illuminate\Support\ServiceProvider;
use Zento\CatalogSearch\Services\CatalogSearchService;
use Zento\Kernel\Facades\PackageManager;

class Entry extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('catalogsearch_service', function ($app) {
            return new CatalogSearchService();
        });
        PackageManager::class_alias('\Zento\CatalogSearch\Providers\Facades\CatalogSearchService', 'CatalogSearchService');

        $this->app['catalogsearch_service']->registerCriteriaFilter('visibility',
            function ($builder, $value) {
                if (empty($value) || $value === 'storefront') {
                    $builder->where('visibility', '>', 1);
                } else {
                    if ($value !== 'admin') {
                        if (!is_array($value)) {
                            $value = [$value];
                        }
                        $builder->whereIn('visibility', $value);
                    }
                }
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['catalogsearch_service'];
    }
}
