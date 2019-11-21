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
      $pay_id = Request::get('pay_id');
      $note = Request::get('note', '');
      $guest_checkout = Request::get('guest_checkout', Auth::user()->is_guest);
      $client_ip = Request::get('client_ip') ?? Request::ip();

      $eventResult = (new DraftOrderEvent($pay_id, $note, $guest_checkout, $client_ip))->fireUntil();
      if ($eventResult->isSuccess()) {
          (new OrderCreatedEvent($eventResult->getData('order')))->fire();
      }
      return $this->response($eventResult->toArray());
    }
}