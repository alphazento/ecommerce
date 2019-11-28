<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderPaymentItem extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    public $_richData_ = [];

    // protected $fillable = self::PROPERTIES;
}