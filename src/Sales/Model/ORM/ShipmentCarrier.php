<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class ShipmentCarrier extends \Illuminate\Database\Eloquent\Model 
{
    protected $fillable = ['name', 'description'];

    public function methods() {
        // shipping_method_id
        return $this->hasMany(ShipmentMethod::class, 'id', 'carrier_id');
    }
}