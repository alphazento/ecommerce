<?php

namespace Zento\Sales\Event;

class OrderCreatedEvent extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    const HAS_ATTRS = [
        'order'
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->data = [
            'order' => $order
        ];
    }
}