<?php

namespace Zento\PaymentGateway\Http\Controllers;

use Route;
use Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller {
    public function estimate() {
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
                                >this is eway</button>',
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
}