<?php

namespace Zento\Catalog\Model\ORM\Category;

class CategoryDescription extends \Illuminate\Database\Eloquent\Model
{
    public function getForeignKeyName()
    {
        return 'category_id';
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
