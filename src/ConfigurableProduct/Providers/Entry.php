<?php

namespace Zento\ConfigurableProduct\Providers;

use CatalogSearchService;
use Zento\Catalog\Model\ORM\Product as SimpleProduct;
use Zento\ConfigurableProduct\Model\ORM\Product as ConfigurableProduct;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        SimpleProduct::registerType('configurable', ConfigurableProduct::class);
        CatalogSearchService::registerPostSearchHandler(function($items) {
            ConfigurableProduct::assignExtraRelation($items);
        });
    }
}
