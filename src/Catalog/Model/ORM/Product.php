<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model
{
    protected static $RelationModels = [
        'description' => [
            'class' => ProductDescription::class,
            'foreignKey' =>'product_id'
        ]
    ];
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
    use Traits\TraitProductPriceHelper;
}