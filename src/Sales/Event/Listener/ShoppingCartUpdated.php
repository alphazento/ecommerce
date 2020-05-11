<?php

namespace Zento\Sales\Event\Listener;

class ShoppingCartUpdated extends \Zento\Kernel\Booster\Events\BaseListener
{
    /**
     * @param \Zento\Contracts\Interfaces\Catalog\IShoppingCart $event
     * @return void
     */
    protected function run($event)
    {
        // \zento_assert($event->shoppingCart);
        if ($event->shoppingCart) {
            $total = 0;
            $items_quantity = 0;
            foreach ($event->shoppingCart->items ?? [] as $item) {
                \zento_assert($item);
                $total += $item->row_price;
                $items_quantity += $item->quantity;
            }
            $event->shoppingCart->items_quantity = $items_quantity;
            $event->shoppingCart->grand_total = $total;
            $event->shoppingCart->subtotal = $total;
            $event->shoppingCart->subtotal_with_discount = $event->shoppingCart->subtotal;
            $event->shoppingCart->total = $event->shoppingCart->grand_total + $event->shoppingCart->shipping_fee + $event->shoppingCart->handle_fee;
        }
    }
}
