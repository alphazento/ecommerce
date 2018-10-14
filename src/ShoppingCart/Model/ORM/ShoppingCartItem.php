<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
 
    // public static $preload_relations = [
    //     'items',
    //     'billing_address',
    //     'shipping_address',
    //     'withcount' => ['items']
    // ];

    protected $fillable = [
        'id',
        'guid',
        'cart_guid',
        'name',
        'sku',
        'price',
        'description',
        'url',
        'image',
        "quantity",
        "minQuantity",
        "maxQuantity",
        "stackable", //boolean
        'shippable',
        'taxable',
        'taxes',//  []
        'duplicatable',
        "unitPrice",
        "totalPrice",
        'options'
    ];
}