<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;

class PaymentTransaction extends \Illuminate\Database\Eloquent\Model {
    protected $fillable = [
        'payment_method',
        'payment_transaction_id',
        'payment_transaction_id_hash',
        'payment_status',
        'customer_id',
        'total_due',
        'amount_authorized',
        'amount_paid',
        'amount_refunded',
        'amount_canceled',
        'raw_response'
    ];

    public static function create(array $attributes=[]) {
        $transaction = new static($attributes);
        $transaction->payment_transaction_id_hash = md5($transaction->payment_transaction_id);
        $transaction->save();
        return $transaction;
    }
}
