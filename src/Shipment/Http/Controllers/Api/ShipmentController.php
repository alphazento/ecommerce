<?php

namespace Zento\Shipment\Http\Controllers\Api;

use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Shipment\Providers\Facades\ShipmentService;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;

class ShipmentController extends ApiBaseController
{
    use \Zento\ShoppingCart\Http\Controllers\Api\TraitShoppingCartHelper;

    /**
     * estimate shipping methods for a shopping cart
     * @group Shipment
     */
    public function estimateShippingMethods()
    {
        return $this->tapCart(function ($cart) {
            if ($params = Request::get('shipping_address')) {
                $address = new ShoppingCartAddress($params);
                zento_assert($address);
                return $this->withData(ShipmentService::estimate($cart, $address, null, null));
            } else {
                if ($address = $cart->shipping_address) {
                    return $this->withData(ShipmentService::estimate($cart, $address, null, null));
                } else {
                    return $this->error(420, 'Address is empty.');
                }
            }
        });
    }
}
