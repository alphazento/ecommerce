<?php

namespace Zento\Customer\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class Customer extends \Zento\Passport\Model\User
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    protected $fillable = [
        'group_id',
        'store_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password'
    ];

    public static function getPreloadRelations() {
        return [
            'default_billing_address',
            'default_shipping_address',
        ];
    }

    public function default_billing_address() {
        return $this->hasOne(CustomerAddress::class, 'id', 'default_billing_address_id');
    }

    public function default_shipping_address() {
        return $this->hasOne(CustomerAddress::class, 'id', 'default_shipping_address_id');
    }

    public function getNameAttribute($value) {
        if ($this->middlename) {
            return sprinft('%s %s %s', $this->firstname, $this->middlename, $this->lastname);
        } else {
            return sprinft('%s %s', $this->firstname, $this->lastname);
        }
    }
}