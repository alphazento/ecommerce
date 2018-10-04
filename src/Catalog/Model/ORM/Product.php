<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use Traits\TraitDescriptionHelper;
    use Traits\TraitProductPriceHelper;

    protected $desciptionModel = ProductDescription::class;
    protected $desciptionModelForeignKey = 'product_id';

    public $preload_relations = [
        'descriptionDataset',
        'priceDataset',
        'specialPriceDataset'
    ];
}