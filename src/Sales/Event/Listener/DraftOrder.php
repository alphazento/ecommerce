<?php

namespace Zento\Sales\Event\Listener;

use Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

use Zento\Sales\Model\ORM\SalesOrder;
use Zento\Sales\Model\ORM\SalesAddress;
use Zento\Sales\Model\ORM\SalesShipment;
use Zento\Sales\Model\ORM\SalesOrderPayment;
use Zento\Sales\Model\ORM\SalesOrderStatus;
use Zento\Sales\Providers\Facades\SalesService;

class DraftOrder extends \Zento\Kernel\Booster\Events\BaseListener
{
    protected function run($event) {
        $order = SalesService::placeOrder($event->shoppingCart, 
            $event->paymentTransaction,
            'freeshipping', 
            'free',
            '0',
            '');
        return $event->createResult(true, ['order' =>  $order]);
    }
}
