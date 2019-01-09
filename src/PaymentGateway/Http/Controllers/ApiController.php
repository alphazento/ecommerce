<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
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
            $result = $method->capture(Request::all());
            if ($result->canCreateOrderAfterCapture()) { //payment success
                $shoppingCart = \generateReadOnlyModelFromArray('\Zento\ShoppingCart\Model\ORM\ShoppingCart', Request::get('shopping_cart'));
                \zento_assert($shoppingCart);
                $orderData = (new \Zento\Checkout\Event\CreatingOrder(
                    $shoppingCart, 
                    $result->getPaymentDetail())
                )->fireUntil();
                $orderData['payment_data'] = $result->getData();
                return ['status' => $orderData['success'] ? 201 : 420, 'data' => $orderData];
            } else {
                return ['status' => $result->isSuccess() ? 201 : 420, 'data' => $result->getData()];
            }
        } else {
            return ['status' => 404, 'data' => ['messages'=>['Payment method not support by server.']]];
        }
    }
}