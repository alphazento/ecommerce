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
        'quantity', 
        'shippable',
        'taxable',
        'unit_price', 
        'custom_price',
        'row_price',
        'options'
    ];
}