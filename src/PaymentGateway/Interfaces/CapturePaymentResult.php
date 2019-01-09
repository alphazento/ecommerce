<?php

namespace Zento\PaymentGateway\Interfaces;

class CapturePaymentResult
{
  protected $data;

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

  public function setPaymentDetail(array $data) {
    $this->data['payment_detail'] = \array2ReadOnlyObject('\Zento\PaymentGateway\Interfaces\PaymentDetail', $data);
    return $this;
  }

  public function getPaymentDetail() {
    return $this->data['payment_detail'];
  }

  public function getPaymentName() {
    return $this->data['method_name'];
  }

  public function isSuccess() {
    return $this->data['success'];
  }

  public function getData() {
    return $this->data;
  }

  public function canCreateOrderAfterCapture() {
    return $this->data['success'] && $this->data['can_create_order'];
  }
}