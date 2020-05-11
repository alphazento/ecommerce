<?php

namespace Zento\Sales\Event;

class DraftOrderEvent extends \Zento\Kernel\Booster\Events\BaseEvent
{
    const HAS_ATTRS = [
        'pay_id',
        'transaction',
    ];

    /**
     * Create a new event instance.
     *
     * @param  array $shoppingCart
     * @param  string  $paymentTransaction
     * @return void
     */
    public function __construct(string $pay_id, $transaction)
    {
        $this->data = compact('pay_id', 'transaction');
    }
}
