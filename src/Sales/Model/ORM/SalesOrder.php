<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrder extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = [
        'order_number',
        'is_backorder',
        'invoice_no',
        'store_id',
        'status_id',
        'coupon_code',
        'customer_id',
        'guest_checkout', #$cart->customer->isGuest(),
        'ext_customer_id',
        'ext_order_id',
        'customer_note',
        'applied_rule_ids',
        'remote_ip' ,
        'total_item_qty',
        'payment_transaction_id' ,
        'total_amount_include_tax' ,
        'base_currency_code' ,
        'order_currency_code',
        'base_to_order_currency_rate'
    ];
    
    public $_richData_ = [
        'payment',
    ];

    public function payment() {
        return $this->hasOne(SalesOrderPayment::class, 'order_id');
    }

    public function shipment() {
        return $this->hasOne(SalesShipment::class, 'order_id');
    }
}
