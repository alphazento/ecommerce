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
        BladeTheme::breadcrumb('/', 'Home');
        $pthis->prepareApiGuestToken(Request::user());
        $swatches = ProductService::getProductSwatches();
        BladeTheme::addGlobalViewData(compact('swatches'));

        return $pthis->{$method}($parameters);
    }

    protected function genApiUrl($path) {
        return sprintf('/api/v1/%s', $path);
    }

    protected function prepareApiGuestToken($user) {
        if (env('API_GUEST_TOKEN_ENABLED')) {
            $apiGuestToken = sprintf('Guest %s', encrypt(json_encode($user->toArray())));
            BladeTheme::addGlobalViewData(compact('apiGuestToken'));
        }
        return $this;
    }

    protected function getCart($fullResp = false) {
        $resp = BladeTheme::requestInnerApi('GET', $this->genApiUrl('cart'));
        if ($resp->success) {
            return $fullResp ? $resp : $resp->data;
        }
        return null;
    }
}
