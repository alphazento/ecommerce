<?php
namespace Zento\PaymentGateway\Interfaces;

interface Method {
    public function canCapturePartial();
    public function canCaptureOnce();
    public function canRefund();
    public function canUseAtAdmin();
    public function canEdit();
    public function canFetchTransactionInfo();
    public function canReviewPayment();
    public function refund($payment, $amount);
    public function acceptPayment($payment);
    public function denyPayment($payment);
}