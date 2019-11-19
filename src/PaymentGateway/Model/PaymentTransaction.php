<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\Interfaces\IPaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentTransaction extends \Illuminate\Database\Eloquent\Model implements IPaymentTransaction{
    protected $fillable = self::PROPERTIES;

    public static function create(array $attributes=[]) {
        $transaction = new static($attributes);
        $transaction->pay_id = md5(sprintf('%s:%s', $transaction->payment_method, $transaction->ext_transaction_id));
        $transaction->save();
        return $transaction;
    }

    public static function recordTransaction($payment_method, 
        IShoppingCart $cart, 
        $ext_transaction_id, 
        $authorized_amount,
        $paid_amount
    ) {
        $shipping_address = PaymentTransactionAddress::createFromCart($cart);
        $transaction = static::create(
            [
                'payment_method' => $payment_method,
                'status' => 'completed',
                'ext_transaction_id' => $ext_transaction_id,
                'customer_id' => $cart->customer_id, 
                'customer_email' => $cart->email, 
                'currency' => $cart->currency,
                'subtotal' => $cart->subtotal,
                'shipping' => $cart->shipping_fee,
                'shipping_address_id' => 0,  //$shipping_address->id
                'total' =>$cart->total,
                'amount_due' => $cart->total,
                'amount_authorized' => $authorized_amount,
                'amount_paid' => $paid_amount, 
                'amount_refunded' => 0,
                'amount_canceled' => 0,
            ]
        );

        PaymentTransactionItem::createItemsFromCart($cart, $transaction->id);
        return $transaction;
    }
}
