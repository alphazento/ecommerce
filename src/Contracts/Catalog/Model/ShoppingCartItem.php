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
        'price',
        'custom_price',
        'description',
        'url', 
        'image',  
        'quantity', 
        'min_quantity', 
        'max_quantity', 
        // 'stackable', 
        'shippable',
        'taxable',
        'duplicatable', 
        'unit_price', 
        'total_price',
        // 'options'
    ];
}