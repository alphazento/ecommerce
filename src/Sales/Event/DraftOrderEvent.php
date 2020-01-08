<?php

namespace Zento\Sales\Event;

use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IPaymentTransaction;

class DraftOrderEvent extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'pay_id'
    ];

    /**
     * Create a new event instance.
     *
     * @param  array $shoppingCart
     * @param  string  $paymentTransaction
     * @return void
     */
    public function __construct(string $pay_id)
    {
        $this->data = compact('pay_id');
    }
}