<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesAddress extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = [
        'name',
        'company',
        'address1',
        'address2',
        'city',
        'country',
        'postal_code',
        'state',
        'phone',
    ];
}