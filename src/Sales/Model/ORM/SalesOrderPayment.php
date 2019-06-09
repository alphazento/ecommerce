<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderPayment extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    protected $fillable = [
        'order_id',
        'comment',
        'payment_method',
        'payment_transaction_id',
        'amount_due',
        'amount_authorized',
        'amount_paid',
        'amount_refunded',
        'amount_canceled'
    ];

    public static function getPreloadRelations() {
        return [
            "items",
            'withcount' => ['items']
        ];
    }

    public function items() {
        return $this->hasMany(SalesOrderPaymentItem::class, 'payment_id');
    }
}