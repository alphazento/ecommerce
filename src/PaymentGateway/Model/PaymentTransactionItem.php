<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\Interfaces\IPaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentTransactionItem extends \Illuminate\Database\Eloquent\Model {
    protected $fillable = [
        'payment_transaction_id',
        'item_type',
        'name',
        'quantity',
        'price',
        'sku',
        'currency',
        'amount',
        'canceled',
        'invoiced',
        'refunded'
    ];
    
    public static function createItemsFromCart(IShoppingCart $cart, $payment_transaction_id) {
        //record product/service items
        foreach($cart->items ?? [] as $item) {
            $attrs = [ 
                'payment_transaction_id' => $payment_transaction_id,
                'item_type' => 'product',
                'name'  => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'sku' => $item->sku,
                'amount'=> $item->row_price,
                'canceled' => 0,
                'invoiced' => 0,
                'refunded' => 0
            ];
            static::create($attrs);
        }

        //record sales rules
        // foreach($cart->applied_rules) {
        // }
    }
}
