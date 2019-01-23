<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class EavAttributeOptionSwatch extends Magento2Model
{
    protected $table = 'eav_attribute_option_swatch';
    protected $primaryKey = 'swatch_id';
}