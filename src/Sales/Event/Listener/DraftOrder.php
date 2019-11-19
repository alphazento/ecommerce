<?php

namespace Zento\Sales\Event\Listener;

use Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\ORM\SalesOrderStatus;
use Zento\Sales\Providers\Facades\SalesService;

class DraftOrder extends \Zento\Kernel\Booster\Events\BaseListener
{
    protected function run($event) {
        $order = SalesService::placeOrder($event->pay_id, 
            $event->note,
            $event->guest_checkout,
            $event->client_ip);
        return $event->createResult(true, ['order' =>  $order]);
    }
}
