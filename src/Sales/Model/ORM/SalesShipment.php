<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesShipment extends \Illuminate\Database\Eloquent\Model 
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = ['order_id'];
    public $_richData_ = [
        'address',
        'carrier',
        'metod',
    ];

    public function address() {
        return $this->hasOne(SalesAddress::class, 'sales_address_id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'customer_id');
    }

    public function carrier() {
        // shipping_carrier_id
        return $this->hasOne(ShipmentCarrier::class, 'carrier_id');
    }

    public function method() {
        // shipping_method_id
        return $this->hasOne(ShipmentMethod::class, 'method_id');
    }
}