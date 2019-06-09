<?php

namespace Zento\Checkout\Http\Controllers;


use Route;
use Request;
use Registry;
use CheckoutService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * create order as an api entry
     *
     * @return void
     */
    public function createOrder() {
        $paymentTransaction = \array2ReadOnlyObject(Request::get('payment_transaction'), '\Zento\PaymentGateway\Model\PaymentTransaction');
        $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::get('shopping_cart'));
        $order = CheckoutService::draftOrder($paymentTransaction, $shoppingCart);
        return ['status' => $order->isSuccess() ? 201 : 420, 'data' => $order->getData()];
    }
}