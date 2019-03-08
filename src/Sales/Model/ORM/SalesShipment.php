<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesShipment extends \Illuminate\Database\Eloquent\Model 
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    protected $fillable = ['order_id'];
    public static function getPreloadRelations() {
        return [
            'billing_address',
            'shipping_address',
            // 'withcount' => ['items']
        ];
    }

    // protected $fillable = self::PROPERTIES;

    public function billing_address() {
        return $this->hasOne(SalesAddress::class, 'billing_address_id');
    }

    public function shipping_address() {
        return $this->hasOne(SalesAddress::class, 'shipping_address_id');
    }
}