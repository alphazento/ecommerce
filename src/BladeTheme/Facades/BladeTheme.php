<?php

namespace Zento\BladeTheme\Facades;

class BladeTheme extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bladetheme';
    }
}
