<?php

namespace Zento\BladeTheme\Http\Controllers;

use Route;
use Request;
use BladeTheme;
use ProductService;
use App\Http\Controllers\Controller;

trait TraitThemeRouteOverwritable
{
    static $OverwriteBy;

    public function callAction($method, $parameters) {
        $pthis = $this;
        if (self::$OverwriteBy) {
            $pthis = app(self::$OverwriteBy);
        }

        return call_user_func_array([$pthis, $method], $parameters);
    }


    protected function getCart($fullResp = false) {
        $resp = BladeTheme::requestInnerApi('GET', BladeTheme::apiUrl('cart'));
        if ($resp->success) {
            return $fullResp ? $resp : $resp->data;
        }
        return null;
    }
}
