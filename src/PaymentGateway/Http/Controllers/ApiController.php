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

    public function presubmit() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            list($ret, $data) = $method->preSubmit(Request::all());
            return ['status' => $ret ? 200 : 500, 'data' => $data];
        } else {
            return ['status' => 404, 'data' => 'payment method not found'];
        }
    }

    public function submit() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            return ['status' => 200, 'data' => $method->submit(Request::all())];
        } else {
            return ['status' => 404, 'data' => 'payment method not found'];
        }
    }

    public function postsubmit() {
        if ($method = PaymentGateway::getMethod(Route::input('method'))) {
            return $method->postSubmit(Request::all());
        } else {
            return ['status' => 404, 'data' => 'payment method not found'];
        }
    }
}