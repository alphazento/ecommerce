<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class EavAttributeSet extends Magento2Model
{
    protected $table = 'eav_attribute_set';
    protected $primaryKey = 'attribute_set_id';
}