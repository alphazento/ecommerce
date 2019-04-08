<?php

namespace Zento\CatalogSearch\Providers\Facades;

class CatalogSearchService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'catalogsearch_service';
    }
}
