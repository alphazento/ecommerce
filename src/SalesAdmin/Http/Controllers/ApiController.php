<?php

namespace Zento\SalesAdmin\Http\Controllers;


use Route;
use Request;
use Registry;

use Zento\SalesAdmin\Model\ORM\SalesOrder;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class ApiController extends ApiBaseController
{
    function getOrders() {
      $orders = SalesOrder::orderBy('id', 'desc')->paginate();
      return $this->withData($orders);
    }

    function getOrder() {
      $order = SalesOrder::where('id', Route::input('id'))->first();
      return $this->withData($orders);
    }
}