<?php
namespace Zento\PaymentGateway\Interfaces;

interface Method {
    public function getCode();
    public function getTitle();

    public function canOrder();
    public function canAuthorize();
    public function canCapture();

    public function canCapturePartial();
    public function canCaptureOnce();
    
    public function canRefund();
    public function canUseAtFront();
    public function canUseCheckout();

    public function canUseForCountry($country);
    public function canUseForCurrency($currencyCode);
    public function validate();

    public function authorize($payment_data);
    public function capture(array $payment_data):\Zento\PaymentGateway\Interfaces\CapturePaymentResult;

    /**
     * prepare for client side
     *
     * @param string $clientType
     * @return array
     */
    public function prepareForClientSide($clientType = 'web');
}