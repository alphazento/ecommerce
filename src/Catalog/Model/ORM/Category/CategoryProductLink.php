<?php

namespace Zento\Catalog\Model\ORM\Category;

class CategoryProductLink extends \Illuminate\Database\Eloquent\Model
{
    public function getForeignKeyName()
    {
        return 'category_id';
    }

    protected $fillable = [
        'category_id',
        'product_id',
        'direct_relation', // if true means product belongs to category directly, otherwise it belongs to it's sub category
        'position',
    ];
}
