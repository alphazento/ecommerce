<?php

namespace Zento\M2Data\Model\ORM\Eavs\Category;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;
use Zento\M2Data\Model\ORM\EavAttribute;

class CategoryTextAttribute extends \Zento\M2Data\Model\ORM\Eavs\AttrBase
{
    protected $table = 'catalog_category_entity_text';
}