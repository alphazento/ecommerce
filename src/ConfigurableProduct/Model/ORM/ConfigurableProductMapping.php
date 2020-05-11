<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Zento\Catalog\Model\ORM\Product as SimpleProduct;

class ConfigurableProductMapping extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id', 'parent_id',
    ];
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne(SimpleProduct::class, 'id', 'product_id');
    }
}
