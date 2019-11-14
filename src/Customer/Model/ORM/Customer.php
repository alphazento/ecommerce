<?php

namespace Zento\Customer\Model\ORM;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Customer extends \Zento\Passport\Model\User
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    protected $fillable = [
        'group_id',
        'store_id',
        'name',
        'email',
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

    public static function findDummyCustomer($uuid) {
        $email = 'dm'. $uuid;
        return static::where('email', $email)->first();
    }
    
    public static function requestDummyCustomer($uuid) {
        $password = Str::random(8);

        $email_hash = md5('dm'. $uuid);
        if ($dummy = static::where('email_hash', $email_hash)->first()) {
            $dummy->password = bcrypt($password);
            $dummy->save();
        } else {
            $dummy = static::create([
                'group_id' => 0,
                'store_id' => 0,
                'name' => 'Guest',
                'email' => '',
                'email_hash' => $email_hash,
                'password' => bcrypt($password),
                'is_guest' => 1
            ]);
        }
        return [$dummy, $password];
    }
}