<?php

namespace Zento\DownloadableProduct\Providers;

use ProductService;
use CatalogSearchService;

use Zento\DownloadableProduct\Model\ORM\Product as DownloadableProduct;

class Plugin extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        DownloadableProduct::registerType(DownloadableProduct::MODEL_TYPE, DownloadableProduct::class);
        $callback = function($items) {
            if (DownloadableProduct::isRichMode()) {
                DownloadableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
