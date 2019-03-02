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
      $orders = SalesOrder::orderBy('id', 'desc')->paginate(30);
      return ['status' => 200, 'data'=> $orders];
    }
}