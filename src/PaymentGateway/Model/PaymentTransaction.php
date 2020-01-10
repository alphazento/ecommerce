<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\Interfaces\IPaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentTransaction extends \Illuminate\Database\Eloquent\Model implements IPaymentTransaction{
    protected $fillable = self::PROPERTIES;

    public static function create(array $attributes=[]) {
        $transaction = new static($attributes);
        $transaction->pay_id = $transaction->genPayId();
        $transaction->save();
        return $transaction;
    }

    protected function genPayId() {
        return md5(sprintf('%s:%s', $this->payment_method, $this->ext_transaction_id));
    }

    public static function recordTransaction($payment_method, 
        IShoppingCart $quote, 
        $ext_transaction_id, 
        $authorized_amount,
        $paid_amount
    ) {
        $data =  [
            'payment_method' => $payment_method,
            'status' => 'completed',
            'ext_transaction_id' => $ext_transaction_id,
            'customer_id' => $quote->customer_id, 
            'customer_email' => $quote->email, 
            'currency' => $quote->currency,
            'amount_due' => $quote->total,
            'amount_authorized' => $authorized_amount,
            'amount_paid' => $paid_amount, 
        ];
        $transaction = new static($data);
        $payId = $transaction->genPayId();
        if ($exits = static::where('pay_id', '=', $payId)->first()) {
            return $exits;
        }
        $transaction->quote = json_encode($quote->toArray()); 
        $transaction->pay_id = $payId; 
        $transaction->save();
        // PaymentTransactionItem::createItemsFromCart($quote, $transaction->id);
        return $transaction;
    }
}
