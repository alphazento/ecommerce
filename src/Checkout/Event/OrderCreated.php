<?php

namespace Zento\Checkout\Event;

class OrderCreated extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    const HAS_ATTRS = [
        'order',
        'shoppingCart'
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order, $shoppingCart)
    {
        $this->data = [
            'order' => $order,
            'shoppingCart' => $shoppingCart,
        ];
    }
}