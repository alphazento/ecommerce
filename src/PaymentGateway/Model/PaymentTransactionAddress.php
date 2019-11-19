<?php

namespace Zento\PaymentGateway\Model;

use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\Interfaces\IPaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentTransactionAddress extends \Illuminate\Database\Eloquent\Model {
    protected $fillable = [
        'name',
        'company', 
        'address1',
        'address2',
        'city', 
        'country',
        'postal_code',
        'state',
        'phone'
    ];
    
    public static function createFromCart(IShoppingCart $cart) {
        // $attrs = [ 
        //     'name' => $payment_transaction_id,
        //     'company' => 'product',
        //     'address1'  => $item->name,
        //     'address2' => $item->quantity,
        //     'city' => $item->price,
        //     'country' => $item->sku,
        //     'postal_code'=> $item->row_price,
        //     'state' => 0,
        //     'phone' => 0,
        // ];
        // static::create($attrs);
    }
}
