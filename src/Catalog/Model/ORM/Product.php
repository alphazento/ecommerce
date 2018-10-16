<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\Product
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
    use Traits\TraitProductPriceHelper;
    use Traits\TraitRealationMutatorHelper;
    use Traits\ParallelProduct;

    protected static $DesciptionModel = ProductDescription::class;
    protected static $DesciptionModelForeignKey = 'product_id';
    public static $preload_relations = [
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