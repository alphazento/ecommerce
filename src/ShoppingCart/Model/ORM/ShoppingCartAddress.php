<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartAddress extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\ShoppingCartAddress
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    protected $fillable = [
        'customer_id',
        'firstname',  
        'middlename',  
        'lastname',  
        "company",
        "address1",
        "address2",
        "city",
        "country",
        "postal_code",
        "state",
        "phone",
        "address_type"
    ];
}