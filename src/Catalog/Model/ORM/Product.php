<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Product
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public function product_description() {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }

    public function product_price() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function product_special_price() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    public static function getPreloadRelations() {
        return [
            'product_description' => [
                'description', 'name', 'meta_title', 'meta_description', 'meta_keyword'
            ],
            'product_price' => [
                'rrp', 'cost', 'price',
            ],
            'product_special_price' => [
                'special_price', 'special_from', 'special_to'
            ]
        ];
    } 
}