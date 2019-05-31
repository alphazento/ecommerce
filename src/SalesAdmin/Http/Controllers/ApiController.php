<?php

namespace Zento\SalesAdmin\Http\Controllers;


use Route;
use Request;
use Registry;

use Zento\SalesAdmin\Model\ORM\SalesOrder;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends \App\Http\Controllers\Controller
{
    function getOrders() {
      $orders = SalesOrder::orderBy('id', 'desc')->paginate();
      return ['status' => 200, 'data'=> $orders];
    }

    function getOrder() {
      $order = SalesOrder::where('id', Route::input('id'))->first();
      return ['status' => 200, 'data'=> $order];
    }
}