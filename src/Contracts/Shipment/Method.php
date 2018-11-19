<?php

namespace Zento\Contracts\Shipment;

interface Method extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['method_code', 'title', 'sort_order', 'active_frontend', 'active_admin', 'description'];
    public function estimate(\Zento\Contracts\Catalog\Model\ShoppingCart $cart,
       \Zento\Contracts\Catalog\Model\ShoppingCartAddress $shipping_address, 
       $customer,
       $arrivalDate) : EstimateResult;
}