<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
use App\Http\Controllers\Controller;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Zento\Contracts\ROModel\ROShoppingCart;

class ApiController extends Controller {
    use \Zento\ShoppingCart\Http\Controllers\Api\TraitShoppingCartHelper;

    public function estimate() {
        // return $this->tapCart(function($cart) {
            $quote = 0;
            $user = 0;
            $shippingAddress = 0;
            return [
                "status" => 200,
                "data" => PaymentGateway::estimate($quote, $user, $shippingAddress, 'reactjs')
            ];
        // }
    }

    /**
     * prepare data for payment gateway
     *
     * @return void
     */
    public function prepare() {
        list($ret, $data) = PaymentGateway::preparePaymentData(Route::input('method'),
            new ROShoppingCart(Request::get('shopping_cart')));
        return ['status' => $ret ? 200 : 420, 'data' => $data];
    }

    /**
     * capture or validate caputred payment
     * if you want to create order directlly in this method, it wll call create order
     *
     * @return void
     */
    public function capture() {
        list($ret, $data) = PaymentGateway::capturePayment(Route::input('method'), Request::all());
        return ['status' => $ret ? 201 : 420, 'data' => $data];
    }
}