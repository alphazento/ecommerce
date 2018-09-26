<?php

namespace Zento\M2Data\Model\ORM\Catalog;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryIntAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryTextAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryVarcharAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDatetimeAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDecimalAttribute;

class CategoryProduct extends \Zento\M2Data\Model\ORM\Magento2Model
{
    protected $table = 'catalog_category_product';
}