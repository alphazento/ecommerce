<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryIntAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryTextAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryVarcharAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDatetimeAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDecimalAttribute;

class Magento2Model extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'magento2';
}