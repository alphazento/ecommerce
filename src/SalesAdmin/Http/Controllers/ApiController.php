<?php

namespace Zento\SalesAdmin\Http\Controllers;


use Route;
use Request;
use Registry;

use Zento\SalesAdmin\Model\ORM\SalesOrder;
use Zento\SalesAdmin\Model\ORM\AdminComment;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\SalesAdmin\Model\Filters\SalesOrderFilter;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends ApiBaseController
{
    public function __construct() {
      parent::__construct();
    }

    function getOrders(SalesOrderFilter $filters) {
      $filters->mixin(new \Zento\SalesAdmin\Model\Filters\MixFilter);
      $orders = SalesOrder::filter($filters)->paginate();
      return $this->withData($orders);
    }

    function getOrder() {
      $order = SalesOrder::where('id', Route::input('id'))->first();
      return $this->withData($orders);
    }

    function setOrderStatus() {
      if ($order = SalesOrder::where('id', Route::input('id'))->first()) {
        $status_id = Route::input('status_id');
        if ($status_id !== null) {
          if ($order->status_id != $status_id) {
            if ($comment = Request::get('comment', false)) {
              $notify = Request::get('notify', false);
              $item = new AdminComment();
              $item->order_id = $order->id;
              $item->comment = $comment;
              // $item->admin_id = Auth::user()->id;
              $item->admin_id = 0;
              $item->notify_to_customer = $notify;
              try {
                $item->save();
              } catch(\Exception $e) {
                return $this->error(422, 'Not able to save comment.');
              }
            }
            $order->status_id = $status_id;
            $order->save();
          }
          return $this;;
        }
      }
      return $this->error(422, 'Not able to update order status');
    }
}