<?php

namespace Zento\Catalog\Model\ORM;

use Illuminate\Support\Collection;

class Category extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicColumn\DynamicColumnAbility;
}