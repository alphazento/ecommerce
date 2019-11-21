<?php

namespace Zento\PaypalPayment\Http\Controllers;

use Response;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class ApiController extends ApiBaseController
{
    public function __construct() {
        $this->mode = config('paymentgateway.paypalexpress.mode');
    }

    public function renderPaypalConfigJs() {
        $mode = config('paymentgateway.paypalexpress.mode');
        $clientId = config(sprintf('paymentgateway.paypalexpress.%s.client_id', $mode));
        // $clientId = 'AQy7c9Sm4XjVt2T9oWfMT5r6u8NXWIdeJovtG0r-Od5XTIn-AKLJujEEZefISsWe8U2AqrDEj8DfoF5K';
        $jsCode = 'var paypal_config = {
                    env: "sandbox",
                    // PayPal Client IDs - replace with your own
                    // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                    client: {
                        sandbox: "' . $clientId .'",
                        production: ""
                    }
                }';
        return Response::make($jsCode, 200)
            ->header('Content-Type', 'application/javascript');
    }
}
