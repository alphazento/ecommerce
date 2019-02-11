<?php

namespace Zento\Customer\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class Customer extends \Zento\Passport\Model\User
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    protected $fillable = [
        'group_id',
        'store_id',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'real_email',
        'password',
        'is_guest'
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

    public function createDummyCustomer() {
        $uuid = uniqid('', true);
        $password = substr($uuid, 0, 8);
        $dummy = static::create([
            'group_id' => 0,
            'store_id' => 0,
            'firstname' => 'Guest',
            'lastname' => '',
            'email' => 'dummy' . $uuid,
            'real_email' => '',
            'password' => bcrypt($password),
            'is_guest' => 1
        ]);
        return [$dummy, $password];
    }
}