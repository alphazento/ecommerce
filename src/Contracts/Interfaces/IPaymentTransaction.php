<?php

namespace Zento\Contracts\Interfaces;

interface IPaymentTransaction extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'payment_method',
        'payment_status',
        'ref_id',
        'ref_id_hash',
        'customer_id',
        'amount_due',
        'amount_authorized',
        'amount_paid',
        'amount_refunded',
        'amount_canceled',
        'success',
        'raw_response'
    ];
}