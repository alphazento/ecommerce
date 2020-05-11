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
     * @param boolean $canDraftOrderAfterCapture
     */
    public function __construct($method_name, $ext_transaction_id, $amount, $payment_req_data)
    {
        $this->data['method_name'] = $method_name;
        $this->data['ext_transaction_id'] = $ext_transaction_id;
        $this->data['amount'] = $amount;
        $this->data['payment_req_data'] = $payment_req_data;
    }

    /**
     * set success flg
     *
     * @param [type] $flg
     * @return void
     */
    public function success($flg)
    {
        $this->data['success'] = true;
        return $this;
    }

    public function setPaymentTransaction(PaymentTransaction $transaction)
    {
        $this->data['payment_transaction'] = $transaction;
        return $this;
    }

    public function setMessages($messages)
    {
        $this->data['messages'] = $messages;
        return $this;
    }

    public function getData($key)
    {
        return $this->data[$key] ?? null;
    }

    public function isSuccess()
    {
        return $this->data['success'];
    }

    public function toArray()
    {
        return $this->data;
    }
}
