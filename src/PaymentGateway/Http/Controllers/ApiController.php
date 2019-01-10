<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
use App\Http\Controllers\Controller;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Zento\PaymentGateway\Interfaces\PaymentDetail;

class ApiController extends Controller {
    public function estimate() {
        $quote = 0;
        $user = 0;
        $shippingAddress = 0;
        return [
            "status" => 200,
            "data" => PaymentGateway::estimate($quote, $user, $shippingAddress, 'reactjs')
        ];
    }

    public function prepare() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::all());
            \zento_assert($shoppingCart);
            list($ret, $data) = $method->prepare($shoppingCart);
            return ['status' => $ret ? 200 : 500, 'data' => $data];
        } else {
            return ['status' => 404, 'data' => ['messages'=>['Payment method not support by server.']]];
        }
    }

    public function capture() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            $paymentResult = $method->capture(Request::all());
            if ($paymentResult->canCreateOrderAfterCapture()) { //payment success
                $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::get('shopping_cart'));
                $order = $this->_createOrder($paymentResult->getPaymentDetail(), $shoppingCart);
                $order->addData('payment_data', $paymentResult->toArray());
                return ['status' => $order->isSuccess() ? 201 : 420, 'data' => $order->getData()];
            } else {
                return ['status' => $paymentResult->isSuccess() ? 201 : 420, 'data' => $paymentResult->toArray()];
            }
        } else {
            return ['status' => 404, 'data' => ['messages'=>['Payment method not support by server.']]];
        }
    }

    public function createOrder() {
        $paymentDetail = \array2ReadOnlyObject(Request::get('payment_detail'), '\Zento\PaymentGateway\Interfaces\PaymentDetail');
        $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::get('shopping_cart'));
        $order = $this->_createOrder($paymentDetail, $shoppingCart);
        return ['status' => $order->isSuccess() ? 201 : 420, 'data' => $order->getData()];
    }

    public function _createOrder(PaymentDetail $paymentDetail, \Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart) {
        \zento_assert($paymentDetail);
        \zento_assert($shoppingCart);
        return (new \Zento\Checkout\Event\CreatingOrder(
                $shoppingCart, 
                $paymentDetail)
            )->fireUntil();
    }
}