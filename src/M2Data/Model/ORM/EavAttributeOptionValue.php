<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class EavAttributeOptionValue extends Magento2Model
{
    protected $table = 'eav_attribute_option_value';
    protected $primaryKey = 'value_id';
}