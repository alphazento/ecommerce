<?php

namespace Zento\Catalog\Providers\Facades;

class CategoryService extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'category_service';
    }
}
