<?php

namespace Zento\Contracts\Interfaces\Catalog;

interface IShoppingCartItem  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'id', 
        'cart_id', 
        'name', 
        'product_id', 
        'sku', 
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