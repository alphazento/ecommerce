<?php

namespace Zento\M2Data\Model\ORM\Eavs\Product;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ProductTextAttribute extends \Zento\M2Data\Model\ORM\Eavs\AttrBase
{
    protected $table = 'catalog_product_entity_text';
}