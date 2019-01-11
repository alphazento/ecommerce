<?php

namespace Zento\Checkout\Event;

class OrderCreated extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    const HAS_ATTRS = [
        'order_id',
        'shopping_cart_id'
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $order_id, string $shopping_cart_id)
    {
        $this->data = [
            'order_id' => $order_id,
            'shopping_cart_id' => $shopping_cart_id,
        ];
    }
}