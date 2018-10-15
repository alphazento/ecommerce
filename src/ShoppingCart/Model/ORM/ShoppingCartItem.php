<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    public static $preload_relations = [
        'options',
    ];

    protected $fillable = [
        'cart_id',
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
    ];

    public function options() {
        return $this->hasMany(ShoppingCartItemOption::class, 'item_id');
    }
}