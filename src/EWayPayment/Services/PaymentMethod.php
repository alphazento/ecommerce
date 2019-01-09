<?php

namespace Zento\EWayPayment\Services;

use Config;
use Registry;
use Closure;

class PaymentMethod implements \Zento\PaymentGateway\Interfaces\Method {
    public function getCode() {
        return 'ewaypayment';
    }

    public function getTitle(){
        return config('ewaypayment.title', 'Secure Credit Card(eWay)');
    }

    public function canOrder() {
        return config('ewaypayment.title');
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
        return config('paymentgateway.eway.frontend.enabled');
    }

    public function canUseAtAdmin() {
        return config('paymentgateway.eway.admin.enabled');
    }

    public function canUseCheckout() {
        return config('ewaypayment.can.usecheckout');
    }

    public function canEdit() {
        return config('ewaypayment.can.edit');
    }

    public function canFetchTransactionInfo() {
        return config('ewaypayment.can.fetchtransactioninfo');
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

    protected $accesscodeRepo;
    protected function getAccesscodeRepo() {
        if (!$this->accesscodeRepo) {
            $this->accesscodeRepo = new AccessCodeRepo;
        }
        return $this->accesscodeRepo;
    }

    public function prepare(\Zento\Contracts\Catalog\Model\ShoppingCart $shoppingCart) {
        return $this->getAccesscodeRepo()->requestNewCode($shoppingCart);
    }

    /**
     * capture
     *
     * @param array $payment_data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data):\Zento\PaymentGateway\Interfaces\CapturePaymentResult {
        $returns = $this->getAccesscodeRepo()->checkAccessCode($payment_data['AccessCode']);
        return (new \Zento\PaymentGateway\Interfaces\CapturePaymentResult($payment_data['AccessCode'], ture))->success($returns['success']);
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
        return [
            "name" => $this->getCode(),
            "title" => $this->getTitle(),
            "withCards" =>true,
            // "html" => 
            "js" => [
                "depends"=> [
                        [
                            "namespaces" => ["eWAYUtils", "eWAY"],
                            "src" => "https://secure.ewaypayments.com/scripts/eWAY.min.js"
                        ]
                    ],
                    "entry" => "http://alphazento.local.test/js/eway2.js?v="  . time()
            ],
            'params' => [
                'prepare_url' => "/payment/prepare/" . $this->getCode() 
            ]
        ];
    }
}