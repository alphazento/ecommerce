<?php

namespace Zento\Catalog\Model\ORM\Product;

class ProductSpecialPrice extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id',
        'customer_group_id',
        'special_price',
        'special_from',
        'special_to',
    ];

    public function getForeignKeyName()
    {
        return 'product_id';
    }
}
