<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrder extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    protected $fillable = [
        'order_number',
        'is_backorder',
        'invoice_no',
        'store_id',
        'status_id',
        'coupon_code',
        'customer_id',
        'customer_is_guest', #$cart->customer->isGuest(),
        'ext_customer_id',
        'ext_order_id',
        'customer_note',
        'applied_rule_ids',
        'remote_ip' ,
        'total_item_count',
        'cart_address_id',
        'cart_id' ,
        'total_amount_include_tax' ,
        'base_currency_code' ,
        'order_currency_code',
        'base_to_order_currency_rate'
    ];

    public static function getPreloadRelations() {
        return [
            'payment',
            // 'shipment',
            'status',
            'status_history',
            // 'withcount' => ['items']
        ];
    }

    // protected $fillable = self::PROPERTIES;

    public function payment() {
        return $this->hasOne(SalesOrderPayment::class, 'order_id');
    }

    public function shipment() {
        return $this->hasOne(SalesShipment::class, 'order_id');
    }

    public function status() {
        return $this->hasOne(SalesOrderStatus::class, 'id');
    }

    public function status_history() {
        return $this->hasMany(SalesOrderStatusHistory::class, 'order_id');
    }
}