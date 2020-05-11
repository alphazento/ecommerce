<?php

namespace Zento\Customer\Event\Listener;

use Zento\Customer\Providers\Facades\CustomerService;

/**
 * Listener for Event \Zento\Customer\Event\PassportTokenIssued
 */
class PassportTokenIssued extends \Zento\Kernel\Booster\Events\BaseListener
{
    /**
     * @return void
     */
    protected function run($event)
    {
        if ($event->isRegistering
            && $event->dummyCustomer
            && $event->customer) {
            //copy address from dummy user to customer
            if ($collection = CustomerService::getCustomerAddresses($event->dummyCustomer->id)) {
                foreach ($collection as $item) {
                    $address = $item->replicate();
                    $address->customer_id = $event->customer->id;
                    $address->save();
                }
            }
        }
    }
}
