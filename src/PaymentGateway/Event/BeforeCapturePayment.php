<?php

namespace Zento\PaymentGateway\Event;

class BeforeCapturePayment extends \Zento\Kernel\Booster\Events\BaseEvent
{
    const HAS_ATTRS = [
        'method',
        'data',
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
            'data' => $data,
        ];
    }
}
