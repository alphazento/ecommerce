<?php

namespace Zento\Checkout\Http\Controllers;


use Request;
use Registry;

use Illuminate\Support\Collection;
use Zento\Contracts\ROModel\ROPaymentTransaction;
use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\Checkout\Providers\Facades\CheckoutService;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * create order as an api entry
     *
     * @return void
     */
    public function draftOrder() {
        $paymentTransaction = new ROPaymentTransaction(Request::get('payment_transaction'));
        $shoppingCart = new ROShoppingCart(Request::get('shopping_cart'));
        $order = CheckoutService::draftOrder($paymentTransaction, $shoppingCart);
        return ['status' => $order->isSuccess() ? 201 : 420, 'data' => $order->getData()];
    }
}