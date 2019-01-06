<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesAddress extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public static function getPreloadRelations() {
        return [
            // 'withcount' => ['items']
        ];
    }

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'company',
        'address1',
        'address2',
        'city',
        'country',
        'postal_code',
        'state',
        'phone',
    ];
}