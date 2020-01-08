<?php

namespace Zento\Sales\Http\Controllers\Api;

use Auth;
use Route;
use Request;
use Response;
use Registry;
use Product;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Sales\Event\DraftOrderEvent;
use Zento\Sales\Event\OrderCreatedEvent;
use Zento\Sales\Providers\Facades\SalesService;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class SalesController extends ApiBaseController
{
    public function createOrder() {
      Request::validate([
          'pay_id'=>"required|string|max:32"
      ]);
      
      $data = Request::only('pay_id', 'customer_email', 'note', 'shipping_address', 'client_ip', 'guest_checkout');
      $data['guest_checkout'] = $data['guest_checkout'] ?? Auth::user()->is_guest;
      $data['client_ip'] = $data['client_ip']?? Request::ip();

      $eventResult = (new DraftOrderEvent($data['pay_id'], 
        $data['customer_email'], 
        $data['shipping_address'],
        $data['note'] ?? null,
        $data['guest_checkout'], 
        $data['client_ip']))->fireUntil();
      if ($eventResult->isSuccess()) {
          (new OrderCreatedEvent($eventResult->getData('order')))->fire();
      }
      return $this->response($eventResult->toArray());
    }
}