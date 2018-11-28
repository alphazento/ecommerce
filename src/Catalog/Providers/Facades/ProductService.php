<?php

namespace Zento\Catalog\Providers\Facades;

class ProductService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'product_service';
    }
}
