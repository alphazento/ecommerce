<?php

namespace Zento\ShoppingCart\Event\Listener;

use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;

/**
 * Listener for Event \Zento\Customer\Event\PassportTokenIssued
 */
class PassportTokenIssued extends \Zento\Kernel\Booster\Events\BaseListener {
    /**
     * @return void
     */
    protected function run($event) {
        // dd($event->shoppingCart);
        dump($event);
        if ($event->dummyCustomer) {
            if ($event->isRegistering) {
                // ShoppingCartService::getCartByUserId()
            }
        }
    }
}