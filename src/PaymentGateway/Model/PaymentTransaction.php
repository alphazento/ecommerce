<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\IPaymentTransaction;

class PaymentTransaction extends \Illuminate\Database\Eloquent\Model implements IPaymentTransaction{
    protected $fillable = self::PROPERTIES;

    public static function create(array $attributes=[]) {
        $transaction = new static($attributes);
        $transaction->payment_transaction_id_hash = md5($transaction->payment_transaction_id);
        $transaction->save();
        return $transaction;
    }
}
