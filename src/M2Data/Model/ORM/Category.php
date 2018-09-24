<?php

namespace Zento\M2Data\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryIntAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryTextAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryVarcharAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDatetimeAttribute;
use Zento\M2Data\Model\ORM\Eavs\Category\CategoryDecimalAttribute;

class Category extends Magento2Model
{
    protected $table = 'catalog_category_entity';
    protected $primaryKey = 'entity_id';

    public function integerattrs() {
        return $this->hasMany(CategoryIntAttribute::class, 'entity_id');
    }

    public function textattrs() {
        return $this->hasMany(CategoryTextAttribute::class, 'entity_id');
    }

    public function varcharattrs() {
        return $this->hasMany(CategoryVarcharAttribute::class, 'entity_id');
    }

    public function datetimeattrs() {
        return $this->hasMany(CategoryDatetimeAttribute::class, 'entity_id');
    }

    public function decimalattrs() {
        return $this->hasMany(CategoryDecimalAttribute::class, 'entity_id');
    }
}