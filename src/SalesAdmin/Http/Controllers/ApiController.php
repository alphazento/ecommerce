<?php

namespace Zento\SalesAdmin\Http\Controllers;


use Route;
use Request;
use Registry;

use Zento\SalesAdmin\Model\ORM\SalesOrder;
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
          $order->status_id = $status_id;
          $order->save();
          return $this;;
        }
      }
      return $this->error(422, 'Not able to update order status');
    }
}