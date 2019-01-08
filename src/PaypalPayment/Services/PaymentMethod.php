<?php

namespace Zento\PaypalPayment\Services;

use Zento\PaypalPayment\Model\PaymentCapturer;
use Zento\PaypalPayment\Model\PaymentPrimer;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;

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

    public function authorize($payment, $amount) {
        return true;
    }

    public function refund($payment, $amount) {
        return true;
    }

    public function acceptPayment($payment) {
        return true;
    }

    public function denyPayment($payment) {
        return true;
    }

    public function preSubmit($params) {
        return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart("104b47b8-0f10-4669-9e02-b04c0daacf58"));
    }

    /**
     * this submit is for payment gateway which using server side submit.
     * if you are using frontend submit, do not extend this function
     *
     * @param [type] $params
     * @return void
     */
    public function submit($params) {
    }

    public function postSubmit($params) {
        $returns = (new PaymentCapturer)->execute($params['payment_data']);
        $returns['next'] = 'create_order';
        return $returns;
    }

    public function capture($payment, $amount) {
        return true;
    }

    public function prepareForClient($clientType = 'web') {
        switch($clientType) {
            case 'web':
                return $this;
                break;
            case 'reactjs':
                return $this->prepareForReactjs();
                break;
        }
    }

    protected function prepareForReactjs() {
        $url = (string)(route('payment.postsubmit', ['method' => $this->getCode() ]));
        return [
            "name" => $this->getCode(),
            "title" => $this->getTitle(),
            "withCards" =>false,
            "html" => '<img src="https://yes.edu.my/wp-content/uploads/2018/10/paypal.png" width=200 />',
            "js" => [
                "depends"=> [
                    [
                        "namespaces" => ["paypal_config"],
                        "src" => "http://alphazento.local.test/rest/v1/paypal_config"
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
                "entry" => "http://alphazento.local.test/js/paypalexpress.js?v="  . time()
            ],
            'params' => [
                'postsubmit' => str_replace('https:', 'http:', $url)
            ]
        ];
    }

    public function renderMethodView() {
        return '';
    }
}