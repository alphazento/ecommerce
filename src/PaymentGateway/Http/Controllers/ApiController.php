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
        return [
            "status" => 200,
            "data" => [
                [
                    "name" => "eway",
                    "title" => "Secure Credit Card(eWay)",
                    "withCards" =>true,
                    "html" => 
                            '<button id="zentocheckout-button-place-order"
                                type="button"
                                className="btn-proceed-checkout zentocheckout-btn-checkout zentocheckout-place"
                                title="Place Order"\
                                onclick="window.eway.preCapture()"\
                                >this is eway</button>
                            <input id="ewaytest" name="number" onkeyup="window.eway.onInputChanged(this.id)"/>
                                ',
                    "js" => [
                        "depends"=> [
                            [
                            "namespaces" => ["eWAYUtils", "eWAY"],
                            "src" => "https://secure.ewaypayments.com/scripts/eWAY.min.js"
                        ]
                        ],
                        "entry" => "http://alphazento.local.test/js/eway2.js?v="  . time()
                    ]
                ],
                [
                    "name" => "securepay" ,
                    "title" => "Secure Credit Card(securepay)",
                    "withCards" =>true,
                    "html" => 
                            '<button id="zentocheckout-button-place-order"
                                type="button"
                                className="btn-proceed-checkout zentocheckout-btn-checkout zentocheckout-place"
                                title="Place Order"
                                onclick="window.eway.preCapture()"
                            >this is eway</button>',
                    "js" => [
                        "entry" => "http://alphazento.local.test/js/eway2.js?v=" . time()
                    ]
                ]
            ]
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
            return ['status' => 200, 'data' => $method->postSubmit(Request::all())];
        } else {
            return ['status' => 404, 'data' => 'payment method not found'];
        }
    }
}