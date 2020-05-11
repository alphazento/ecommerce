<?php

namespace Zento\DownloadableProduct\Providers;

use CatalogSearchService;
use ProductService;
use Zento\DownloadableProduct\Model\ORM\Product as DownloadableProduct;

class Plugin extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        DownloadableProduct::registerMorph(DownloadableProduct::MODEL_TYPE);
        $callback = function ($items) {
            if (DownloadableProduct::isRichMode()) {
                DownloadableProduct::assignExtraRelation($items);
            }
        };
        ProductService::registerLazyRelationHandler($callback);
        CatalogSearchService::registerPostSearchHandler($callback);
    }
}
