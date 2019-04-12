<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCartItem  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'id', 
        'cart_id', 
        'name', 
        'product_id', 
        'sku', 
        'product_hash',
        'price',
        'custom_price',
        'quantity', 
        'shippable',
        'taxable',
        'unit_price', 
        'row_price',
        'options'
    ];
}