<?php

namespace Zento\PaypalPayment\Services;

use Zento\PaypalPayment\Model\PaymentCapturerV1;
use Zento\PaypalPayment\Model\PaymentCapturerV2;
use Zento\PaypalPayment\Model\PaymentPrimer;
use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;
use Zento\PaymentGateway\Interfaces\CapturePaymentResult;

class PaymentMethod implements \Zento\PaymentGateway\Interfaces\Method {
    public function getCode() {
        return 'paypalexpress';
    }

    public function getTitle(){
        return config('paypalexpress.title', 'Paypal Express Checkout');
    }

    public function canOrder() {
        return config('paypalexpress.title');
    }

    public function canAuthorize(){
        return true;
    }

    public function canCapture() {
        return true;
    }

    public function canCapturePartial() {
        return true;
    }

    public function canCaptureOnce() {
        return true;
    }
    
    public function canRefund() {
        return true;
    }

    public function canUseInternal() {
        return true;
    }

    public function canUseAtFront() {
        return config('paypalexpress.can.useatfront');
    }

    public function canUseAtAdmin() {
        return false;
    }

    public function canUseCheckout() {
        return config('paypalexpress.can.usecheckout');
    }

    public function canEdit() {
        return config('paypalexpress.can.edit');
    }

    public function canFetchTransactionInfo() {
        return config('paypalexpress.can.fetchtransactioninfo');
    }

    public function canUseForCountry($country) {
        return true;
    }

    public function canUseForCurrency($currencyCode) {
        return true;
    }

    public function canReviewPayment() {
        return true;
    }

    public function validate() {
        return true;
    }

    public function authorize($payment_data) {
        return true;
    }

    public function prepare($params) {
        // return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart("104b47b8-0f10-4669-9e02-b04c0daacf58"));
        return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart($params['cart_id']));
    }

    /**
     * Base on different payment method, 
     *
     * @param array $data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data): \Zento\PaymentGateway\Interfaces\CapturePaymentResult {
        $version = $payment_data['version'] ?? 'v1';
        $returns = [];
        switch($version) {
            case 'v1' :
                $returns = (new PaymentCapturerV1)->execute($payment_data['payment']);
                break;
            case 'v2' :
                $returns = (new PaymentCapturerV2)->execute($payment_data['payment']);
        }

        $success = $returns['success'] ?? false;
        $extTransactionId = $success ? $returns['transaction_id'] : 0;
        $totalAmount =  0;
        if ($success && ($returns['data']['transactions'] ?? false)) {
            $totalAmount = $returns['data']['transactions'][0]['amount']['total'];
        } else {
            $success = false;
        }

        return (new CapturePaymentResult($this->getCode(), $extTransactionId, $totalAmount, $payment_data['payment']))
            ->success($success);
    }

    public function prepareForClientSide($clientType = 'web') {
        switch($clientType) {
            case 'web':
                return $this;
                break;
            case 'reactjs':
                return $this->prepareForReactjs();
                break;
            case 'vue': 
                return $this->prepareForVue();
                break;
        }
    }

    protected function prepareForReactjs() {
        $url = (string)(route('api:payment:capture', ['method' => $this->getCode() ]));
        return [
            "name" => $this->getCode(),
            "title" => $this->getTitle(),
            "withCards" =>false,
            "html" => '<img src="https://yes.edu.my/wp-content/uploads/2018/10/paypal.png" width=200 />',
            "js" => [
                "depends"=> [
                    [
                        "namespaces" => ["paypal_config"],
                        "src" => route('paypay.config')
                    ],
                    [
                        "namespaces" => ["paypal"],
                        "src" => "https://www.paypalobjects.com/api/checkout.js"
                    ]
                    // [
                    //     "namespaces" => ["eWAYUtils", "eWAY"],
                    //     "src" => "https://secure.ewaypayments.com/scripts/eWAY.min.js"
                    // ]
                ],
                "entry" => asset("js/paypalexpress.js?v="  . time())
            ],
            'params' => [
                'capture_url' => str_replace('https:', 'http:', $url)
            ]
        ];
    }

    protected function prepareForVue() {
        $url = (string)(route('api:payment:capture', ['method' => $this->getCode() ]));
        $mode = config('paymentgateway.paypalexpress.mode');
        $clientId = config(sprintf('paymentgateway.paypalexpress.%s.client_id', $mode));
        return [
            'name' => $this->getCode(),
            'title' => $this->getTitle(),
            'component' => 'paypal-card',
            'withCards' =>false,
            'image' => [
                'src' => 'https://yes.edu.my/wp-content/uploads/2018/10/paypal.png',
                'width' => '170px',
                'height' => '60px',
            ],
            'configs' => [
                'mode' => $mode,
                'currency' => 'AUD',
                'credentials' => [
                    'sandbox' => $mode === 'sandbox' ? $clientId : '',
                    'production'  => $mode === 'sandbox' ? '' : $clientId
                ],
                'style' => [
                    'label' => "checkout",
                    'size' => "responsive",
                    'shape'=> "pill",
                    'color'=> "gold"
                ],
                'params' => [
                    'capture_url' => str_replace('https:', 'http:', $url)
                ]
            ]
        ];
    }
}