<?php
namespace Zento\ShoppingCart\Http\Controllers\Api;

use Auth;
use Route;
use Request;
use Registry;
use ShoppingCartService;

trait TraitShoppingCartHelper {
    protected function tapCart(\Closure $callbak, $forceCreateForMine = false) {
        if (!Auth::check()) {
            return response('', 401);
        } elseif ($cart = ShoppingCartService::getMyCart($forceCreateForMine)) {
            return \call_user_func($callbak, $cart);
        }
        return ['status'=> 404, 'error' => 'cart not found.'];
    }
}