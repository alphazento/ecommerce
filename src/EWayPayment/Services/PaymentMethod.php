<?php

namespace Zento\EWayPayment\Services;

use Config;
use Registry;
use Closure;
use Zento\PaymentGateway\Interfaces\CapturePaymentResult;
use Zento\PaymentGateway\Model\PaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\ROModel\ROShoppingCart;

class PaymentMethod implements \Zento\PaymentGateway\Interfaces\IMethod {
    public function getCode() {
        return 'ewaypayment';
    }

    public function getTitle(){
        return config('ewaypayment.title', 'Secure Credit Card(eWay)');
    }

    public function canOrder() {
        return true;
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
        return config(Consts::CONFIG_KEY_ENABLE_FOR_FRONTEND);
    }

    public function canUseAtAdmin() {
        return config(Consts::CONFIG_KEY_ENABLE_FOR_BACKEND);
    }

    public function canUseCheckout() {
        return true;
    }

    public function canEdit() {
        return true;
    }

    public function canFetchTransactionInfo() {
        return true;
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

    public function prepare(IShoppingCart $shoppingCart) {
        return $this->getAccesscodeRepo()->requestNewCode($shoppingCart);
    }

    /**
     * capture
     *
     * @param array $payment_data
     * @return \Zento\PaymentGateway\Interfaces\CapturePaymentResult
     */
    public function capture(array $payment_data): \Zento\PaymentGateway\Interfaces\CapturePaymentResult {
        list($success, $eWayResponse, $messages) = $this->getAccesscodeRepo()->checkAccessCode($payment_data['AccessCode']);
        $extTransactionId = $success ? $eWayResponse['TransactionID'] : 0;
        $totalAmount = $success ? $eWayResponse['TotalAmount']/100 : 0;
        return (new CapturePaymentResult($this->getCode(), $extTransactionId, $totalAmount, $payment_data['AccessCode']))
            ->success($success)
            ->setMessages($messages);
    }

    public function prepareForClientSide($clientType = 'web') {
        switch($clientType) {
            case 'web':
                return $this;
                break;
        }
    }
}