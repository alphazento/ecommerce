<?php

namespace Zento\ShoppingCart\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class ShoppingCartModified extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'shoppingCart'
    ];
    
    /**
     * Create a new event instance.
     *
     * @param  \Zento\Contracts\Catalog\Model\ShoppingCart  $shoppingCart
     * @return void
     */
    public function __construct(\Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart)
    {
        $this->data = [
            'shoppingCart' => $shoppingCart
        ];
    }

    protected function afterFireUntil(\Zento\Kernel\Booster\Events\EventFiredResult $result) : \Zento\Kernel\Booster\Events\EventFiredResult {
        if ($result->isSuccess()) {
            if ($shoppingCart = $this->shoppingCart) {
                $shoppingCart->update();
            }
        } 
        return $result;
    }
}
