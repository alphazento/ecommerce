<?php

namespace Zento\WebShoppingCart\Event\Listener;

use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;

/**
 * Listener for Event \Zento\Customer\Event\PassportTokenIssued
 */
class AuthLogin extends \Zento\Kernel\Booster\Events\BaseListener {
    /**
     * @return void
     */
    protected function run($event) {
        if ($event->dummyCustomer 
            && $event->customer)
        {
            if ($dummyCart = ShoppingCartService::getCartByUserId($event->dummyCustomer->id)) {
                //if do not merge shopping cart
                //delete mycart
                if ($dummyCart->items_quantity > 0) {
                    $dummyCart->customer_id = $event->customer->id;
                    $dummyCart->email = $event->customer->email;
                    $dummyCart->save();
                }
            }
        }
    }
}