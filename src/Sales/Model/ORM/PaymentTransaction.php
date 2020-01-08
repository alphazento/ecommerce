<?php

namespace Zento\Sales\Model\ORM;

use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\Contracts\Interfaces\IPaymentTransaction;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class PaymentTransaction extends \Zento\PaymentGateway\Model\PaymentTransaction {
    public function order() {
        return $this->hasOne(SalesOrder::class, 'id', 'order_id');
    }

    public function getQuoteAttribute() {
        if (!empty($this->attributes['quote'])) {
            return new ROShoppingCart(json_decode($this->attributes['quote'], true));
        }
        return null;
    }
}
