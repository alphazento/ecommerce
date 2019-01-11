<?php

namespace Zento\ShoppingCart\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class PreAddProduct extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'product',
        'options',
        'quantity',
    ];

    public function __construct($product, $options, $quantity)
    {
        $this->data = [
            'product' => $product,
            'options' => $options,
            'quantity' => $quantity,
        ];
    }
}
