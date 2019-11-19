<?php

namespace Zento\Contracts\Interfaces;

interface IPaymentTransaction extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'payment_method',
        'status',
        'pay_id',
        'ext_transaction_id',
        'customer_id',
        'customer_email',
        'shipping_address_id',
        'currency',
        'subtotal', 
        'shipping', 
        'total',
        'amount_due',
        'amount_authorized',
        'amount_paid',
        'amount_refunded',
        'amount_canceled'
    ];
}