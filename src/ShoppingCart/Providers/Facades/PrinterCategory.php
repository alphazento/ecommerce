<?php

namespace Zento\Catalog\Providers\Facades;

class PrinterCategory extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'printercategory';
    }
}
