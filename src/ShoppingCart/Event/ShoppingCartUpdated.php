<?php

namespace Zento\ShoppingCart\Event;

class ShoppingCartUpdated extends \Zento\Kernel\Booster\Events\BaseEvent
{
    const HAS_ATTRS = [
        'shoppingCart',
    ];

    /**
     * Create a new event instance.
     *
     * @param  \Zento\Contracts\Interfaces\Catalog\IShoppingCart  $shoppingCart
     * @return void
     */
    public function __construct(\Zento\Contracts\Interfaces\Catalog\IShoppingCart $shoppingCart)
    {
        $this->data = [
            'shoppingCart' => $shoppingCart,
        ];
    }

    protected function afterFireUntil(\Zento\Kernel\Booster\Events\EventFiredResult $result): \Zento\Kernel\Booster\Events\EventFiredResult
    {
        if ($result->isSuccess()) {
            if ($shoppingCart = $this->shoppingCart) {
                $shoppingCart->update();
            }
        }
        return $result;
    }
}
