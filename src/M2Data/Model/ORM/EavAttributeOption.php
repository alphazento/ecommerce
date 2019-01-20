<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class EavAttributeOption extends Magento2Model
{
    protected $table = 'eav_attribute_option';
    protected $primaryKey = 'option_id';

    public function value() {
        return $this->hasOne(EavAttributeOptionValue::class, 'option_id', 'option_id');
    }
}