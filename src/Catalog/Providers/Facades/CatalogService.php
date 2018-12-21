<?php

namespace Zento\Catalog\Providers\Facades;

class CatalogService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'catalog_service';
    }
}
