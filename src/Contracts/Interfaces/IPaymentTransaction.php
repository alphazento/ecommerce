<?php

namespace Zento\Contracts\Interfaces;

interface IPaymentTransaction extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'pay_id',
        'ext_transaction_id',
        'order_id',
        'payment_method',
        'status',
        'pay_id',
        'customer_id',
        'customer_email',
        'currency',
        'amount_due',
        'amount_authorized',
        'amount_paid'
    ];
}