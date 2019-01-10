<?php

namespace Zento\ShoppingCart\Event\Listener;

use Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;

class OrderCreated extends \Zento\Kernel\Booster\Events\BaseListener
{
    /**
     * @param $event
     * @return void
     */
    protected function run($event) 
    {
        if ($event->shopping_cart_id) {
            if ($shopping_cart = ShoppingCart::find($event->shopping_cart_id)) {
                $shopping_cart->status = 9;
                $shopping_cart->save();
            }
        }
    }
}