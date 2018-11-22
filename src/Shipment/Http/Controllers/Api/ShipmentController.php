<?php

namespace Zento\Shipment\Http\Controllers\Api;


use Route;
use Request;
use Registry;
use ShoppingCartService;

use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShipmentController extends \App\Http\Controllers\Controller
{
    // protected function tapCart(\Closure $callbak) {
    //     $cart_guid = Route::input('cart_guid');
    //     if ($cart_guid && $cart = ShoppingCartService::cart($cart_guid)) {
    //         return \call_user_func($callbak, $cart);
    //     } else {
    //         return ['status'=> 404, 'error' => 'cart not found.'];
    //     }
    // }

    public function estimateShippingMethods() {
        $cart_guid = Route::input('cart_guid');
        if ($cart_guid && $cart = ShoppingCartService::cart($cart_guid)) {
            if ($address = Request::get('shipping_address')) {
                $address = new ShoppingCartAddress(Request::all());
                zento_assert($address);
                return \Zento\Shipment\Providers\Facades\ShipmentService::estimate($cart, $address, null, null);
            } else {
                return ['status'=> 420, 'error' => 'Address is empty.'];
            }
        } else {
            return ['status'=> 404, 'error' => 'cart not found.'];
        }
    }
}