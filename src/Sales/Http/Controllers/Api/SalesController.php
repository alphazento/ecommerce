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
  /**
   * create an order by current user
   * @group Customer Sales
   */
  public function createOrder() {
    Request::validate([
        'pay_id'=> "required|string|max:32",
        // 'transaction' => 'required',
    ]);
    $pay_id = Request::get('pay_id');
    $transaction = Request::get('transaction');

    $eventResult = (new DraftOrderEvent($pay_id, $transaction))->fireUntil();
    if ($eventResult->isSuccess()) {
      $order = $eventResult->getData('order');
      (new OrderCreatedEvent($order))->fire();
      if (Request::hasSession()) {
        Request::session()->flash('order_number', $order->order_number);
      }
    }
    return $this->response($eventResult->toArray());
  }
}