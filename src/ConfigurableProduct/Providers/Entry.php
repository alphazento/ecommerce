<?php

namespace Zento\ConfigurableProduct\Providers;

use ProductService;
use CatalogSearchService;

use Zento\Catalog\Model\ORM\Product as SimpleProduct;
use Zento\ConfigurableProduct\Model\ORM\Product as ConfigurableProduct;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        SimpleProduct::registerType('configurable', ConfigurableProduct::class);
        $callback = function($items) {
            if (SimpleProduct::isRichMode()) {
                ConfigurableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
