<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use App\Http\Controllers\Controller;

trait TraitThemeRouteOverwritable
{
    static $OverwriteBy;
    public function callAction($method, $parameters) {
        $pthis = $this;
        if (self::$OverwriteBy) {
            $pthis = app(self::$OverwriteBy);
        }
        if (method_exists($pthis, 'beforeCallAction')) {
            $pthis->beforeCallAction($method);
        }
        return $pthis->{$method}($parameters);
    }
}
