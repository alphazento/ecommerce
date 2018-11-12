<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCart  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['guid', 'email', 'customer_id', 'mode', 'status', 'ship_to_billingaddesss', 'billing_address', 'shipping_address',
        'invoice_number', 'payment_method', 'currency', 'total_weight', 'total',  'items', 'items_count'
    ];
}
