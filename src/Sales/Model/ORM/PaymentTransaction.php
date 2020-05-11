<?php

namespace Zento\Sales\Model\ORM;

use Zento\Contracts\ROModel\ROShoppingCart;

class PaymentTransaction extends \Zento\PaymentGateway\Model\PaymentTransaction
{
    public function order()
    {
        return $this->hasOne(SalesOrder::class, 'id', 'order_id');
    }

    public function getQuoteAttribute()
    {
        if (!empty($this->attributes['quote'])) {
            return new ROShoppingCart(json_decode($this->attributes['quote'], true));
        }
        return null;
    }
}
