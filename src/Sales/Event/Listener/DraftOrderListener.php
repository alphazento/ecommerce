<?php

namespace Zento\Sales\Event\Listener;

use Zento\Sales\Providers\Facades\SalesService;

class DraftOrderListener extends \Zento\Kernel\Booster\Events\BaseListener
{
    protected function run($event)
    {
        $order = SalesService::placeOrder($event->pay_id);
        return $event->createResult(true, ['order' => $order]);
    }
}
