<?php

namespace Zento\PaymentGateway\Event;

class BeforePreparePayment extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'method',
        'shoppingCart',
    ];
    /**
     * Create a new event instance.
     *
     * @param  string $method
     * @param  array  $request data
     * @return void
     */
    public function __construct($method, $data = null)
    {
        $this->data = [
            'method' => $method,
            'shoppingCart' => $data
        ];
    }
}