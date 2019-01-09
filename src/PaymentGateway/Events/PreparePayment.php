<?php

namespace Zento\PaymentGateway\Events;

class PreparePayment extends \Zento\Kernel\Booster\Events\BaseEvent {
    public $method;
    public $data;
    /**
     * Create a new event instance.
     *
     * @param  string $method
     * @param  array  $request data
     * @return void
     */
    public function __construct($method, $data = null)
    {
        $this->method = $method;
        $this->data = $data;
    }
}