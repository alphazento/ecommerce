<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesShipment extends \Illuminate\Database\Eloquent\Model 
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = ['order_id'];
    
    public function getRichDataDefines() {
        return  [
            'address',
            // 'carrier',
            // 'method',
        ];
    }

    public function address() {
        return $this->hasOne(SalesAddress::class, 'id', 'sales_address_id');
    }

    public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function carrier() {
        // shipping_carrier_id
        return $this->hasOne(ShipmentCarrier::class, 'id', 'carrier_id');
    }

    public function method() {
        // shipping_method_id
        return $this->hasOne(ShipmentMethod::class,  'id', 'method_id');
    }
}
