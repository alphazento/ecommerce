<?php

namespace Zento\Contracts\Interfaces\Shipment;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IAddress;

interface IMethod extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['method_code', 'title', 'sort_order', 'active_frontend', 'active_admin', 'description'];

    public function estimate(
        IShoppingCart $cart,
        IAddress $shipping_address, 
        $customer,
        $arrivalDate) : EstimateResult;
}