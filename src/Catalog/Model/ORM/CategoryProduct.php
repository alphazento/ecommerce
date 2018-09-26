<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class CategoryProduct extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'category_id',
        'product_id',
        'position'
    ];
}
