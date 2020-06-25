<?php

namespace Zento\BraintreePayment\Http\Controllers\Api;

use Braintree\Gateway;
use Zento\BraintreePayment\Consts;
use Zento\BraintreePayment\Model\PaymentCapturerV1;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class BraintreeController extends ApiBaseController
{
    /**
     * Get braintree client token.
     *
     * @group Dynamic Attribute
     * @urlParam id required number model's id
     * @urlParam model required string model's type
     */
    public function token()
    {
        $gateway = new Gateway([
            'environment' => config(Consts::PAYMENT_GATEWAY_BRAINTREE_MODE),
            'merchantId' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_MERCHANT_ID_BY_MODE, 'sandbox')),
            'publicKey' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_CLIENT_ID_BY_MODE, 'sandbox')),
            'privateKey' => config(sprintf(Consts::PAYMENT_GATEWAY_BRAINTREE_SECRET_BY_MODE, 'sandbox')),
        ]);
        $token = with(new PaymentCapturerV1)->getGateway()->clientToken()->generate();
        return $this->withData(compact('token'));
    }
}
