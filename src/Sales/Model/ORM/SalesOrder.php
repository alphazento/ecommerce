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
        'status_id',
        'hold_before_status_id',
        'amend_from',
        'resend_from',
        'is_backorder',
        'customer_id',
        'customer_note',
        'is_guest',
        'remote_ip',
        'active',
        'subtotal',
        'total',
        'tax_amount'
    ];
    
    public $_richData_ = [
    ];

    public function payments() {
        return $this->hasMany(PaymentTransaction::class, 'order_id');
    }

    public function shipments() {
        return $this->hasMany(SalesShipment::class, 'order_id');
    }

    public function products() {
        return $this->hasMany(SalesOrderProduct::class, 'order_id');
    }

    public function items() {
        return $this->hasMany(SalesOrderItem::class, 'order_id');
    }
}
