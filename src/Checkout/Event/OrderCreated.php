<?php

namespace Zento\Checkout\Event;

class OrderCreated extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    public $order_id;
    public $shopping_cart_id;
    public $customer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order_id, $shopping_cart_id, $shopping_cart)
    {
        $this->order_id;
        $this->shopping_cart = $shopping_cart;
        $this->shopping_cart_id = $shopping_cart_id;
        // $this->customer = $customer;
    }
}