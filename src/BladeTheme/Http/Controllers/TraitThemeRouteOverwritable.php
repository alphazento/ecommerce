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
        $bladeTheme = BladeTheme::breadcrumb('/', 'Home');
        $pthis->prepareApiGuestToken(Request::user());
        
        $swatches = ProductService::getProductSwatches();
        $bladeTheme->addGlobalViewData(compact('swatches'));

        $bladeTheme->preRouteCallAction($pthis);

        $response = $pthis->{$method}($parameters);
        return $response;
    }

    protected function prepareApiGuestToken($user) {
        if (env('API_GUEST_TOKEN_ENABLED')) {
            $apiGuestToken = sprintf('Guest %s', encrypt(json_encode($user->toArray())));
            BladeTheme::addGlobalViewData(compact('apiGuestToken'));
        }
        return $this;
    }

    protected function getCart($fullResp = false) {
        $resp = BladeTheme::requestInnerApi('GET', BladeTheme::apiUrl('cart'));
        if ($resp->success) {
            return $fullResp ? $resp : $resp->data;
        }
        return null;
    }
}
