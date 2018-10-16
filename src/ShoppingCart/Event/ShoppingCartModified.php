<?php

namespace Zento\ShoppingCart\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class ShoppingCartModified extends \Zento\Kernel\Booster\Events\BaseEvent {

    /**
     * @var \Zento\ShoppingCart\Model\ORM\ShoppingCart
     */
    public $shoppingCart;
    
    /**
     * Create a new event instance.
     *
     * @param  \Zento\ShoppingCart\Model\ORM\ShoppingCart  $shoppingCart
     * @return void
     */
    public function __construct($shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }
}
