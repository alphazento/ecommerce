<?php

namespace Zento\PaymentGateway\Services;

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
        return config('ewaypayment.can.useatfront');
    }

    public function canUseAtAdmin() {
        return config('ewaypayment.can.useatadmin');
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

    protected $accesscodeRepo;
    protected function getAccesscodeRepo() {
        if (!$this->accesscodeRepo) {
            $this->accesscodeRepo = new AccessCodeRepo;
        }
        return $this->accesscodeRepo;
    }

    public function preSubmit($params) {
        return $this->getAccesscodeRepo()->requestNewCode();
    }

    public function submit($params) {
        // $this->authorize()
        // $this->capture()
    }

    public function postSubmit($params) {

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
                'prepare_endpoint' => "/payment/presubmit/" . $this->getCode() 
            ]
        ];
    }

    public function renderMethodView() {
        return '';
    }
}