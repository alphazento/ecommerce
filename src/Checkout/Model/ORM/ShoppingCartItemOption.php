<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartItemOption extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'item_id',
        'product_id',
        'code',
        'value',
    ];
}