<?php

namespace Zento\Contracts\Interfaces\Catalog;

interface IShoppingCart  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['uuid', 'email', 'customer_id', 
        'mode', 'status', 'items_quantity',
        'ship_to_billingaddesss', 'billing_address', 'shipping_address',
        'order_id', 'currency', 'total_weight', 
        'tax_amount', 'grand_total', 'shipping_fee', 'handle_fee', 'subtotal', 
        'subtotal_with_discount', 'total',  'items',  'client_ip',
        // 'items_count',
    ];
}