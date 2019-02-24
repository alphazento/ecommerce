<?php

namespace Zento\Customer\Event;

class PassportTokenIssued extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'dummyCustomer',
        'currentCustomer',
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
        // \Zento\Customer\Model\ORM\Customer $current,
        array $requestParams, 
        $isRegistering)
    {
        $this->data = [
            'dummyCustomer' => $customer,
            // 'currentCustomer' => $current,
            'requestParams' => $requestParams,
            'isRegistering' => $isRegistering,
        ];
    }
}