<?php

namespace Zento\PaymentGateway\Interfaces;

interface PaymentDetail extends \Zento\Contracts\AssertAbleInterface
{
  const PROPERTIES = [
    'payment_method', 
    'payment_transaction_id',
    'comment', 
    'total_due',
    'amount_authorized',
    'amount_paid', 
    'amount_refunded',
    'amount_canceled' 
  ];
}