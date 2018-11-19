<?php

namespace Zento\ShoppingCart\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class PreAddProduct extends \Zento\Kernel\Booster\Events\BaseEvent {
    public $product;
    public $options;
    public $quantity;

    public function __construct($product, $options, $quantity)
    {
        $this->product = $product;
        $this->options = $options;
        $this->quantity = $quantity;
    }
}
