<?php

namespace Zento\M2Data\Model\ORM\Eavs\Category;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class CategoryIntAttribute extends \Zento\M2Data\Model\ORM\Eavs\AttrBase
{
    protected $table = 'catalog_category_entity_int';
}