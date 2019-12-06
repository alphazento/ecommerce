<?php

namespace Zento\DownloadableProduct\Providers;

use ProductService;
use CatalogSearchService;

use Zento\DownloadableProduct\Model\ORM\Product as DownloadableProduct;

class Entry extends \Illuminate\Support\ServiceProvider
{
    public function boot() {
        DownloadableProduct::registerType(DownloadableProduct::TYPE_ID, DownloadableProduct::class);
        $callback = function($items) {
            if (DownloadableProduct::isRichMode()) {
                DownloadableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
