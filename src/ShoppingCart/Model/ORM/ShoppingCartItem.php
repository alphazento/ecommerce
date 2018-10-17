<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\ShoppingCartItem
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
        "min_quantity",
        "max_quantity",
        "stackable", //boolean
        'shippable',
        'taxable',
        'taxes',//  []
        'duplicatable',
        "unit_price",
        "total_price",
    ];

    public function options() {
        return $this->hasMany(ShoppingCartItemOption::class, 'item_id');
    }
}