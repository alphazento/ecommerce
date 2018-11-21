<?php

namespace Zento\Customer\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class Customer extends \Zento\Passport\Model\User
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public static function getPreloadRelations() {
        return [
            'default_billing_address',
            'default_shipping_address',
            // 'withcount' => ['items']
        ];
    }

    // protected $fillable = self::PROPERTIES;
}