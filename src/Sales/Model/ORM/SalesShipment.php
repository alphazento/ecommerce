<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesShipment extends \Illuminate\Database\Eloquent\Model 
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = ['order_id'];
    public $_richData_ = [
        'billing_address',
        'shipping_address',
    ];

    public function billing_address() {
        return $this->hasOne(SalesAddress::class, 'billing_address_id');
    }

    public function shipping_address() {
        return $this->hasOne(SalesAddress::class, 'shipping_address_id');
    }
}