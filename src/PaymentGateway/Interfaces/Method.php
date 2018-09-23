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

    public function canUseInternal();

    public function canUseAtFront();

    public function canUseAtAdmin();

    public function canUseCheckout();

    public function canEdit();

    public function canFetchTransactionInfo();

    public function canUseForCountry($country);

    public function canUseForCurrency($currencyCode);

    public function canReviewPayment();

    public function validate();

    public function authorize($payment, $amount);

    public function capture($payment, $amount);

    public function refund($payment, $amount);

    public function acceptPayment($payment);

    public function denyPayment($payment);

    public function renderMethodView();
}