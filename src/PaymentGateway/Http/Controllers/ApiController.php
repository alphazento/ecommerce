<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
use CheckoutService;
use App\Http\Controllers\Controller;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;

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

    /**
     * prepare data for payment gateway
     *
     * @return void
     */
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

    /**
     * capture or validate caputred payment
     * if the want to create order directlly in this method, it wll call create order
     *
     * @return void
     */
    public function capture() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            $paymentResult = $method->capture(Request::all());
            if ($paymentResult->canCreateOrderAfterCapture()) { //payment success
                $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::get('shopping_cart'));
                $order = CheckoutService::createOrder($paymentResult->getPaymentDetail(), $shoppingCart);
                $order->addData('payment_data', $paymentResult->toArray());
                return ['status' => $order->isSuccess() ? 201 : 420, 'data' => $order->getData()];
            } else {
                return ['status' => $paymentResult->isSuccess() ? 201 : 420, 'data' => $paymentResult->toArray()];
            }
        } else {
            return ['status' => 404, 'data' => ['messages'=>['Payment method not support by server.']]];
        }
    }

    
}