<?php

namespace Zento\PaypalPayment\Model;
use Config;

class PaymentCapturer {
    const MESSAGES = [
        'UNABLE_TO_COMPLETE_TRANSACTION' => 'Unable to complete transaction',
        'INVALID_PAYMENT_METHOD' => 'Invalid payment method', 
        'PAYER_CANNOT_PAY' => 'Payer can not pay', 
        'CANNOT_PAY_THIS_PAYEE' => 'Can not pay this payee', 
        'REDIRECT_REQUIRED' => 'Redirect required', 
        'PAYEE_FILTER_RESTRICTIONS' => 'Payee filter restrictions'
    ];

    const PRODUCTION_CLIENT_TOKEN_INFO = 'payment/paypalexpress/production/client_token_info';     //do not put in admin.php
    const SANDBOX_CLIENT_TOKEN_INFO = 'payment/paypalexpress/sandbox/client_token_info';     //do not put in admin.php

    protected $is_retrying = false;

    protected $errors = [
        'Payment has been declined.',
        'Please verify your details and try again.',
        'Or you can use another payment method.'
    ];

    public function execute($reqData) {
        if (isset($reqData['paymentID'])) {
            $payId = $reqData['paymentID'];
            $url = $this->getPaymentCheckUrl($payId, 'execute');
            list($status, $results) = $this->httprequest($url , ['payer_id' => $reqData['payerID']]);
            if ($status == 200) {
                if (strtolower($results['state']) == 'failed') {
                    if (isset($results['failure_reason'])) {
                        $this->errors[] = 'Reason:' .  self::MESSAGES[strtoupper($results['failure_reason'])];
                    }
                } else {
                    return ['status' => 200, 'data' => $results];
                }
            }
        }
        return ['status' => 420, 'data' => $this->errors];
    }

    protected function httprequest($url, $data, $method = 'POST') {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization:' . $this->retrieveClientToken($this->is_retrying);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        $response  = curl_exec($ch);
        $http_code = (curl_errno($ch) == 0) ? curl_getinfo($ch, CURLINFO_HTTP_CODE) : 0;
        curl_close($ch);

        if ($http_code == 401 && !$this->is_retrying) {
            $this->is_retrying = true;
            return $this->httprequest($url, $data);
        }

        return [$http_code, json_decode($response, true)];
    }

    protected function retrieveClientToken($force = false) {
        $isProduction = false;
        $tokenInfoKey = $isProduction ? self::PRODUCTION_CLIENT_TOKEN_INFO : self::SANDBOX_CLIENT_TOKEN_INFO;
        if (!$force) {
            $parts = explode(':::', config($tokenInfoKey, ''));
            if (count($parts) == 2) {
                if (time() - $parts[1] < 300) {
                    //not expired
                    return $parts[0];
                }
            }
        }
       
        $clientId = 'AZj9xbFq-EMIObVF1J9slM3d_mS_6dUa3jEHJaAtMcuDsgHintWAh4zXj8rj1IgvF-c6S5auWXFeQN6R';
        $secret = 'ECji2Mboxhly_7yRXc3RAWmL2f8gslGp-Iv3jnqJcffodOtXa21GFQ3XZl3Z1lTswRbDW6yXlK-x-1BU';
        list($code, $ret) = $this->requestToken($clientId, $secret);
        if($code == 200) {
            $token = sprintf('%s %s', $ret['token_type'], $ret['access_token']);
            Config::set($tokenInfoKey, sprintf('%s:::%s', $token, time() + $ret['expires_in']));
            return $token;
        }
    }

    protected function requestToken($clientId, $secret) {
        $headers[] = 'Accept: application/json';
        // $url = ('production' == Store::getConfig(Constants::ENV_MODE)) ? Store::getConfig(Constants::PRODUCTION_TOKEN_URL) : Store::getConfig(Constants::SANDBOX_TOKEN_URL);
        $url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $clientId, $secret));
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response  = curl_exec($ch);
        $http_code = (curl_errno($ch) == 0) ? curl_getinfo($ch, CURLINFO_HTTP_CODE) : 0;
        curl_close($ch);
        return [$http_code, json_decode($response, true)];
    }

    protected function getPaymentCheckUrl($payId, $extraPath = '') {
        // ('production' == ) ? 'https://api.paypal.com/v1/payments/payment' : 
        $url = 'https://api.sandbox.paypal.com/v1/payments/payment';
        return sprintf('%s/%s/%s', $url, $payId, $extraPath);
    }
}
