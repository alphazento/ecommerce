<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class EavAttribute extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'eav_attribute';
    protected $primaryKey = 'attribute_id';

    public function options() {
        return $this->hasMany(EavAttributeOption::class, 'attribute_id', 'attribute_id');
    }
}