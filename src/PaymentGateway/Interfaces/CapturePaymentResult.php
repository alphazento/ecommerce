<?php

namespace Zento\PaymentGateway\Interfaces;

use Zento\PaymentGateway\Model\PaymentTransaction;

class CapturePaymentResult
{
  protected $data;
  protected $payment_transaction;

  /**
   * allow next to auto create order after succesful payment
   *
   * @param boolean $canCreateOrderAfterCapture
   */
  public function __construct($method_name, $payment_req_data, $canCreateOrderAfterCapture) {
    $this->data['method_name'] = $method_name;
    $this->data['payment_req_data'] = $payment_req_data;
    $this->data['can_create_order'] = $canCreateOrderAfterCapture;
  }

  /**
   * set success flg
   *
   * @param [type] $flg
   * @return void
   */
  public function success($flg) {
    $this->data['success'] = true;
    return $this;
  }

  public function setPaymentRawData($data) {
    $this->data['payment_raw_data'] = $data;
    return $this;
  }

  public function getPaymentRawData() {
    return $this->data['payment_raw_data'];
  }

  public function setPaymentTransaction(PaymentTransaction $transaction) {
    $this->payment_transaction = $transaction;
    #\zento_assert($this->payment_transaction);
    return $this;
  }

  public function getPaymentTransaction() {
    return $this->payment_transaction;
  }

  public function getPaymentName() {
    return $this->data['method_name'];
  }

  public function setMessages($messages) {
    $this->data['messages'] = $messages;
    return $this;
  }

  public function getMessages() {
    return $this->data['messages'];
  }

  public function isSuccess() {
    return $this->data['success'];
  }

  public function toArray() {
    return array_merge($this->data, ['payment_transaction' => $this->payment_transaction ? $this->payment_transaction->toArray() : null]);
  }

  public function canCreateOrderAfterCapture() {
    return $this->data['success'] && $this->data['can_create_order'];
  }
}
