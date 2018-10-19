<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Product
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public function description_dataset() {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }

    public function price_dataset() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function special_price_dataset() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    public static function getPreloadRelations() {
        return [
            'description_dataset' => [
                'description', 'name', 'meta_title', 'meta_description', 'meta_keyword'
            ],
            'price_dataset' => [
                'rrp', 'cost', 'price',
            ],
            'special_price_dataset' => [
                'special_price', 'special_from', 'special_to'
            ]
        ];
    } 
}