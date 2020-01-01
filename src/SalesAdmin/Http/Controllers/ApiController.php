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
      SalesOrderFilter::mixin(new \Zento\SalesAdmin\Model\Filters\MixFilter);
    }

    function getOrders(SalesOrderFilter $filters) {
      // $orders = SalesOrder::orderBy('id', 'desc')->paginate();
      // return $this->withData($orders);
      $orders = SalesOrder::filter($filters)->paginate();
      return $this->withData($orders);
    }

    function getOrder() {
      $order = SalesOrder::where('id', Route::input('id'))->first();
      return $this->withData($orders);
    }
}