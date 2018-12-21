<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class CategoryProduct extends \Illuminate\Database\Eloquent\Model
{
    public function getForeignKeyName() {
        return 'category_id';
    }

    protected $fillable = [
        'category_id',
        'product_id',
        'direct_relation', // if true means product belongs to category directly, otherwise it belongs to it's sub category
        'position'
    ];
}
