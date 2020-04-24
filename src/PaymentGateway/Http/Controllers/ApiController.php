<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\PaymentGateway\Providers\Facades\PaymentGateway;
use Zento\Contracts\ROModel\ROShoppingCart;

class ApiController extends ApiBaseController {
    use \Zento\ShoppingCart\Http\Controllers\Api\TraitShoppingCartHelper;

    /**
     * estimate a payment for a shopping cart
     * @group Payment
     */
    public function estimate() {
        $client = Route::input('client');
        $client = 'reactjs';
        // return $this->tapCart(function($cart) {
            $quote = 0;
            $user = 0;
            $shippingAddress = 0;
            return $this->withData(PaymentGateway::estimate($quote, $user, $shippingAddress, $client));
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
        $ret ? $this->success() : $this->error(400);
        return $this->withData($data);
    }

    /**
     * capture or validate caputred payment
     * if you want to create order directlly in this method, it wll call create order
     * @group Payment
     * @return void
     */
    public function capture() {
        list($ret, $data) = PaymentGateway::capturePayment(Route::input('method'), Request::all());
        $ret ? $this->success() : $this->error(400);
        return $this->withData($data);
    }
}