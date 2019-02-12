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
    use \Zento\ShoppingCart\Http\Controllers\Api\TraitShoppingCartHelper;

    public function estimateShippingMethods() {
        return $this->tapCart(function($cart) {
            if ($params = Request::get('shipping_address')) {
                $address = new ShoppingCartAddress($params);
                zento_assert($address);
                return ['status' => 200, 'data' => \Zento\Shipment\Providers\Facades\ShipmentService::estimate($cart, $address, null, null)];
            } else {
                if ($address = $cart->shipping_address) {
                    return['status' => 200, 'data' =>\Zento\Shipment\Providers\Facades\ShipmentService::estimate($cart, $address, null, null)];
                } else {
                    return ['status'=> 420, 'error' => 'Address is empty.'];
                }
            }
        });
    }
}