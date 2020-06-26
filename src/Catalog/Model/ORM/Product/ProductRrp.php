<?php

namespace Zento\Catalog\Model\ORM\Product;

class ProductRrp extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id',
        'cost',
        'rrp',
    ];

    public function getForeignKeyName()
    {
        return 'product_id';
    }
}
