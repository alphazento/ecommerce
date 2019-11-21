<?php

namespace Zento\Sales\Event;

use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\IPaymentTransaction;

class DraftOrderEvent extends \Zento\Kernel\Booster\Events\BaseEvent {
    const HAS_ATTRS = [
        'pay_id',
        'note',
        'guest_checkout',
        'client_ip',
    ];

    /**
     * Create a new event instance.
     *
     * @param  array $shoppingCart
     * @param  string  $paymentTransaction
     * @return void
     */
    public function __construct(string $pay_id, $note, $guest_checkout = 1, $client_ip = null)
    {
        $this->data = compact('pay_id', 'note', 'guest_checkout', 'client_ip');
    }
}