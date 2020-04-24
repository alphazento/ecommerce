<?php

namespace Zento\ConfigurableProduct\Providers;

use ProductService;
use CatalogSearchService;

use Zento\ConfigurableProduct\Model\ORM\Product as ConfigurableProduct;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        ConfigurableProduct::registerType(ConfigurableProduct::MODEL_TYPE, ConfigurableProduct::class);
        $callback = function($items) {
            if (ConfigurableProduct::isRichMode()) {
                ConfigurableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
