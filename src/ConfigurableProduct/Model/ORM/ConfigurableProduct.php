<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Illuminate\Support\Collection;

class ConfigurableProduct extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'product_id', 'parent_id'
    ];
    public $timestamps = false;
}