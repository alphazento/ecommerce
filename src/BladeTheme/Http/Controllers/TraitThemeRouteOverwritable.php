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
        BladeTheme::breadcrumb('/', 'Home');
        return $pthis->prepareApiGuestToken($method)->{$method}($parameters);
    }

    protected function genApiUrl($path) {
        return sprintf('/api/v1/%s', $path);
    }

    protected function prepareApiGuestToken($method) {
        if (env('API_GUEST_TOKEN_ENABLED')) {
            $apiGuestToken = sprintf('Guest %s', encrypt(json_encode(Request::user()->toArray())));
            BladeTheme::addGlobalViewData(compact('apiGuestToken'));
        }
        return $this;
    }

    protected function getCart($fullResp = false) {
        if ($resp = BladeTheme::innerApiProxy('GET', $this->genApiUrl('cart'))) {
            if ($resp['status'] == 404) {
                return null;
            } else {
                return $fullResp ? $resp : $resp['data'];
            }
        }
        return null;
    }
}
