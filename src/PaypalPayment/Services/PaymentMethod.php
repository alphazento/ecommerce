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

    public function authorize($payment_data) {
        return true;
    }

    public function prepare($params) {
        return (new PaymentPrimer)->getPaymentData(ShoppingCartService::cart("104b47b8-0f10-4669-9e02-b04c0daacf58"));
    }

    /**
     * Base on different payment method, 
     *
     * @param array $data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data):\Zento\PaymentGateway\Interfaces\CapturePaymentResult {
        $returns = (new PaymentCapturer)->execute($payment_data['payment']);

        $result = (new \Zento\PaymentGateway\Interfaces\CapturePaymentResult(
            $this->getCode(), 
            $payment_data['payment'], 
            true))
            ->success($returns['success']);
        if ($result->isSuccess()) {
            $totalAmount = $returns['data']['transactions'][0]['amount']['total'];
            $result->setPaymentDetail([
                'payment_method' => $this->getCode(),
                'payment_transaction_id' => $returns['transaction_id'],
                'comment' => '', 
                'total_due' => 0,
                'amount_authorized' => $totalAmount,
                'amount_paid' => $totalAmount, 
                'amount_refunded' => 0,
                'amount_canceled' => 0
            ]);
        }
        return $result;
    }

    public function prepareForClientSide($clientType = 'web') {
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
        $url = (string)(route('payment.capture', ['method' => $this->getCode() ]));
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
                'capture_url' => str_replace('https:', 'http:', $url)
            ]
        ];
    }
}