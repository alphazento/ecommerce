<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
}