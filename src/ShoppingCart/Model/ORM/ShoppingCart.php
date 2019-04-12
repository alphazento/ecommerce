<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCart extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\ShoppingCart
{
    public function billing_address() {
        return $this->hasOne(ShoppingCartAddress::class, 'id', 'billing_address_id');
    }

    public function shipping_address() {
        return $this->hasOne(ShoppingCartAddress::class, 'id', $this->ship_to_billingaddesss ? 'billing_address_id' : 'shipping_address_id');
    }

    public function shipping_information() {
    }

    public function summary()  {
       
    }

    public function items() {
        return $this->hasMany(ShoppingCartItem::class, 'cart_id');
    }
}