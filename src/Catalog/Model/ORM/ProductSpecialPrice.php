<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ProductSpecialPrice extends \Illuminate\Database\Eloquent\Model
{
    public function getForeignKeyName() {
        return 'product_id';
    }
}