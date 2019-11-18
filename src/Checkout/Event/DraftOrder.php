<?php

namespace Zento\Checkout\Event;

use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IPaymentTransaction;

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
    public function __construct(IShoppingCart $shoppingCart, 
        IPaymentTransaction $paymentTransaction)
    {
        $this->data = [
            'shoppingCart' => $shoppingCart,
            'paymentTransaction' => $paymentTransaction
        ];
    }
}