<?php

namespace Zento\Checkout\Event;

class CreatingOrder extends \Zento\Kernel\Booster\Events\BaseEvent {
    
    public $shoppingCart;
    public $paymentDetail;

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
        $this->shoppingCart = $shoppingCart;
        $this->paymentDetail = $paymentDetail;
    }
}