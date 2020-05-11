<?php

namespace Zento\ConfigurableProduct\Providers;

use CatalogSearchService;
use ProductService;
use Zento\ConfigurableProduct\Model\ORM\Product as ConfigurableProduct;

class Plugin extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        ConfigurableProduct::registerMorph(ConfigurableProduct::MODEL_TYPE);
        $callback = function ($items) {
            if (ConfigurableProduct::isRichMode()) {
                ConfigurableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
