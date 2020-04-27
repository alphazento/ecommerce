<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ProductPrice extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id',
        'customer_group_id',
        'price',
        'final_price',  //it calculate by normal price and special price every day
        'discount'
    ];

    public function getForeignKeyName() {
        return 'product_id';
    }
}