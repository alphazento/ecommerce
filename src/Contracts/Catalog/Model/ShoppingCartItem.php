<?php

namespace Zento\Contracts\Catalog\Model;

interface ShoppingCartItem  extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = ['id', 'cart_id', 'name', 'product_id', 'sku', 'price', 'description',
        'url', 'image',  'quantity', 'minquantity', 'maxquantity', 'stackable', 'shippable',
        'taxable', 'duplicatable', 'unit_price', 'total_price',  'options'
    ];
}