<?php

namespace Zento\Checkout\Event;

class CreatingOrder extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    public $shoppingCart;
    public $paymentMethod;
    public $paymentRef;

    /**
     * Create a new event instance.
     *
     * @param  array $shopping_cart
     * @param  string  $payment_method
     * @param  string  $payment_ref
     * @return void
     */
    public function __construct($shoppingCart, $paymentMethod, $paymentRef)
    {
        $this->shoppingCart = $shoppingCart;
        $this->paymentMethod = $paymentMethod;
        $this->paymentRef = $paymentRef;
    }
}