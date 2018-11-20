<?php

namespace Zento\Sales\Http\Controllers\Api;

use Route;
use Request;
use Response;
use Registry;
use Product;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Sales\Providers\Facades\SalesService;

class SalesController extends \App\Http\Controllers\Controller
{
    public function createOrder() {
      if ($shopping_cart = ShoppingCartService::cart(Request::get('cart_guid'))) {
        if ($order = SalesService::placeOrder($shopping_cart, null)) {
          return ['status'=> 201, 'data' => $order];
        } else {
          return ['status'=> 420, 'data' => 'error'];
        }
      }
      return ['status'=> 404, 'error' => 'cart not found.'];
    }
}