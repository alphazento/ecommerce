<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class Addrerss extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
 
    protected $fillable = [
        'id',
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
        "mobile",
        "fax",
        "address_type"
    ];
}