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
            $returns = $method->capture(Request::all());
            if ($returns['success'] && isset($returns['next']) && $returns['next'] == 'create_order') { //payment success
                $orderData = (new \Zento\Checkout\Event\CreatingOrder(
                    Request::get('shopping_cart'), 
                    Route::input('method'), 
                    $returns['transaction_id']))->fireUntil();
                $orderData['payment_data'] = $returns['data'];
                if ($orderData['success'] ?? false) {
                    return ['status' => 201, 'data' => $orderData];
                } else {
                    return ['status' => 420, 'data' => $orderData];
                }
            } else {
                $returns['status'] = $returns['success'] ? 201 : 420;
                return $returns;
            }
        } else {
            return ['status' => 404, 'data' => ['messages'=>['Payment method not support by server.']]];
        }
    }
}