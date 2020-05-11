<?php

namespace Zento\FreeShipping\Model;

use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IAddress;
use Zento\Contracts\Interfaces\Shipment\EstimateResult;

class ShippingMethod extends \Zento\Shipment\Model\ShippingMethod
{
    const CODE = 'freeshipping';
    protected $uqiue_method_name = self::CODE;
    protected $extraAttributes = ['threshold', 'fixed_shipping_fee'];

    public function estimate(IShoppingCart $cart, IAddress $shipping_address, $customer, $arrivalDate): EstimateResult
    {
        $result = new EstimateResult();
        if ($this->active_frontend) {
            $result->method_code = self::CODE;
            $result->available = true;
            $result->description = $this->description;
            if ($cart->subtotal > $this->threshold) {
                $result->title = 'Free Shipping';
                $result->shipping_fee = 0;
            } else {
                $result->title = $this->title;
                $result->shipping_fee = $this->fixed_shipping_fee;
            }
        }
        return $result;
    }
}
