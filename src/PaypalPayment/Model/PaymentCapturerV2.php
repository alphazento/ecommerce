<?php

namespace Zento\PaypalPayment\Model;
use Config;

class PaymentCapturerV2 extends PaymentCapturerV1 {

    public function execute($reqData) {
        if (isset($reqData['id'])) {
            $url = $this->getPaymentCheckUrl($reqData['id']);
            list($status, $results) = $this->httprequest($url, [], 'GET');
            switch($status) {
                case 200:
                    if (strtolower($results['state']) == 'failed') {
                        if (isset($results['failure_reason'])) {
                            $this->errors[] = 'Reason:' .  self::MESSAGES[strtoupper($results['failure_reason'])];
                        }
                    } else {
                        return ['success'=>true, 'data' => $results, 'transaction_id' => $results['id']];
                    }
                    break;
                default:
                    $this->errors[] = 'Paypal Server caused unknow error.';
                    break;
            }
        }
        return ['success'=>false, 'data' => [$reqData], 'messages' => $this->errors];
    }
}
