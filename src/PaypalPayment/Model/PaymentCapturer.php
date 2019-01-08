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

    const SANDBOX_OAUTH2_TOKEN_VALUE = 'paymentgateway.paypalexpress.sandbox.oauth2_token.value';     //do not put in admin.php
    const PRODUCTION_OAUTH2_TOKEN_VALUE = 'paymentgateway.paypalexpress.production.oauth2_token.value';     //do not put in admin.php

    protected $is_retrying = false;

    protected $errors = [];

    protected $mode;
    public function __construct() {
        $this->mode = config('paymentgateway.paypalexpress.mode');
    }

    protected function getConfigValue($key) {
        return config(sprintf('paymentgateway.paypalexpress.%s.%s', $this->mode, $key));
    }

    public function execute($reqData) {
        if (isset($reqData['paymentID'])) {
            $payId = $reqData['paymentID'];
            $url = $this->getPaymentCheckUrl($payId, 'execute');
            list($status, $results) = $this->httprequest($url , ['payer_id' => $reqData['payerID']]);
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
                case 400:
                    if ($results && isset($results['message'])) {
                        $this->errors[] = $results['message'];
                    }
                    break;
                case 404:
                    $this->errors[] = 'Paypal Execute url is not found.';
                    break;
                case 500:
                case 502:
                case 503:
                case 504:
                    $this->errors[] = 'Paypal Server is temporary unavailable';
                    break;
                default:
                    $this->errors[] = 'Paypal Server caused unknow error.';
                    break;
            }
            $reqData['raw_status'] = $status;
        }
        return ['success'=>false, 'data' => [$reqData], 'messages' => $this->errors];
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
        if (!$force) {
            $parts = explode(':::', $this->getConfigValue('oauth2_token.value'));
            if (count($parts) == 2) {
                if (time() - $parts[1] < 300) {
                    //not expired
                    return $parts[0];
                }
            }
        }
       
        list($code, $ret) = $this->requestToken();
        if($code == 200) {
            $token = sprintf('%s %s', $ret['token_type'], $ret['access_token']);
            Config::set(
                sprintf('paymentgateway.paypalexpress.%s.%s', $this->mode,'oauth2_token.value'), 
                sprintf('%s:::%s', $token, time() + $ret['expires_in'])
            );
            return $token;
        }
    }

    protected function requestToken() {
        $headers[] = 'Accept: application/json';
        $oauth2_token_url = $this->getConfigValue('oauth2_token_url');
        $ch = curl_init($oauth2_token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        curl_setopt($ch, CURLOPT_USERPWD, sprintf('%s:%s', $this->getConfigValue('client_id'), $this->getConfigValue('secret')));
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
