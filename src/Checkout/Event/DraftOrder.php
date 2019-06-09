<?php

namespace Zento\Checkout\Event;

use Zento\Contracts\Catalog\Model\ShoppingCart;
use Zento\PaymentGateway\Model\PaymentTransaction;

class DraftOrder extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'shoppingCart',
        'paymentTransaction'
    ];

    /**
     * Create a new event instance.
     *
     * @param  array $shoppingCart
     * @param  string  $paymentTransaction
     * @return void
     */
    public function __construct(ShoppingCart $shoppingCart, 
        PaymentTransaction $paymentTransaction)
    {
        $this->data = [
            'shoppingCart' => $shoppingCart,
            'paymentTransaction' => $paymentTransaction
        ];
    }
}