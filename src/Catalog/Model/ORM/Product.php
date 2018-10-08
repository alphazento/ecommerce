<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
    use Traits\TraitProductPriceHelper;

    protected static $DesciptionModel = ProductDescription::class;
    protected static $DesciptionModelForeignKey = 'product_id';

    public $preload_relations = [
        'descriptionDataset',
        'priceDataset',
        'specialPriceDataset'
    ];
}