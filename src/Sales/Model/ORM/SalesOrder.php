<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrder extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = [
        'store_id',
        'order_number',
        'invoice_id',
        'payment_transaction_id',
        'status_id',
        'hold_before_status_id',
        'amend_from',
        'resend_from',
        'is_backorder',
        'customer_id',
        'customer_note',
        'is_guest',
        'remote_ip',
        'active'
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
