<?php

namespace Zento\Checkout\Event;

class CreateOrder extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'shoppingCart',
        'paymentDetail'
    ];

    /**
     * Create a new event instance.
     *
     * @param  array $shoppingCart
     * @param  string  $paymentDetail
     * @return void
     */
    public function __construct(\Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart, 
        \Zento\PaymentGateway\Interfaces\PaymentDetail $paymentDetail)
    {
        $this->data = [
            'shoppingCart' => $shoppingCart,
            'paymentDetail' => $paymentDetail
        ];
    }
}