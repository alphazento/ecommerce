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
    public function estimateShippingMethods() {
        $cart_guid = Route::input('cart_guid');
        if ($cart_guid && $cart = ShoppingCartService::cart($cart_guid)) {
            if ($params = Request::get('shipping_address')) {
                $address = new ShoppingCartAddress($params);
                zento_assert($address);
                return \Zento\Shipment\Providers\Facades\ShipmentService::estimate($cart, $address, null, null);
            } else {
                if ($address = $cart->shipping_address) {
                    return \Zento\Shipment\Providers\Facades\ShipmentService::estimate($cart, $address, null, null);
                } else {
                    return ['status'=> 420, 'error' => 'Address is empty.'];
                }
            }
        } else {
            return ['status'=> 404, 'error' => 'cart not found.'];
        }
    }
}