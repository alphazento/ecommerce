<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCart  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['guid', 'email', 'customer_id', 'guest_guid', 'mode', 'status', 
        'ship_to_billingaddesss', 'billing_address', 'shipping_address',
        'order_id', 'currency', 'total_weight', 
        'tax_amount', 'grand_total', 'shipping_fee', 'handle_fee', 'subtotal', 
        'subtotal_with_discount', 'total',  'items', 'items_count', 'client_ip'
    ];
}