<?php

namespace Zento\PaypalPayment\Http\Controllers;

use Response;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function renderPaypalConfigJs() {
        $jsCode = 'var paypal_config = {
                    env: "sandbox",
                    // PayPal Client IDs - replace with your own
                    // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                    client: {
                        sandbox: "AZj9xbFq-EMIObVF1J9slM3d_mS_6dUa3jEHJaAtMcuDsgHintWAh4zXj8rj1IgvF-c6S5auWXFeQN6R",
                        production: ""
                    }
                }';
        return Response::make($jsCode, 200)
            ->header('Content-Type', 'application/javascript');
    }
}
