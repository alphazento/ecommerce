<?php

namespace Zento\ShoppingCart\Model\ORM;

class ShoppingCartAddress extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Interfaces\IAddress
{
    protected $fillable = [
        'customer_id',
        'name',
        "company",
        "address1",
        "address2",
        "city",
        "country",
        "postal_code",
        "state",
        "phone",
        "address_type",
    ];
}
