<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCartAddress extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Interfaces\IAddress
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;
    public static function getPreloadRelations() {
        return [
        ];
    }
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
        "address_type"
    ];
}