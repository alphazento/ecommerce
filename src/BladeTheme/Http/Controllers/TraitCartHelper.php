<?php

namespace Zento\BladeTheme\Http\Controllers;

use BladeTheme;

trait TraitCartHelper
{
    protected function getCart($fullResp = false)
    {
        $resp = BladeTheme::requestInnerApi('GET', BladeTheme::apiUrl('cart'));
        if ($resp->success) {
            return $fullResp ? $resp : $resp->data;
        }
        return null;
    }
}
