<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model 
    implements \Zento\Contracts\Catalog\Model\ShoppingCartItem
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    public static function getPreloadRelations() {
        return [
            'options',
        ];
    }

    protected $fillable = self::PROPERTIES;

    public function options() {
        return $this->hasMany(ShoppingCartItemOption::class, 'item_id');
    }
}