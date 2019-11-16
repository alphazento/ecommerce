<?php

namespace Zento\Customer\Event;

class PassportTokenIssued extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'customer',
        'requestParams',
        'isRegistering',
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        \Zento\Customer\Model\ORM\Customer $customer,
        array $requestParams, 
        $isRegistering)
    {
        $this->data = [
            'customer' => $customer,
            'requestParams' => $requestParams,
            'isRegistering' => $isRegistering,
        ];
    }
}