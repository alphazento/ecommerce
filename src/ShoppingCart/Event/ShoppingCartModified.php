<?php

namespace Zento\ShoppingCart\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class ShoppingCartModified extends \Zento\Kernel\Booster\Events\BaseEvent {
    /**
     * @var \Zento\Contracts\Catalog\Model\ShoppingCart
     */
    public $shoppingCart;
    
    /**
     * Create a new event instance.
     *
     * @param  \Zento\Contracts\Catalog\Model\ShoppingCart  $shoppingCart
     * @return void
     */
    public function __construct(\Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }
}
