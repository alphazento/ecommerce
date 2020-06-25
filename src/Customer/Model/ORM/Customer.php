<?php

namespace Zento\Customer\Model\ORM;

use Illuminate\Support\Str;
use ShareBucket;

class Customer extends \Zento\Passport\Model\User
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    protected $fillable = [
        'group_id',
        'store_id',
        'name',
        'email',
        'email_hash',
        'password',
        'is_guest',
    ];

    public function getRichDataDefines()
    {
        return [
            'default_billing_address',
            'default_shipping_address',
        ];
    }

    public function default_billing_address()
    {
        return $this->hasOne(CustomerAddress::class, 'id', 'default_billing_address_id');
    }

    public function default_shipping_address()
    {
        return $this->hasOne(CustomerAddress::class, 'id', 'default_shipping_address_id');
    }

    public static function findOrCreateByEmail($email, $name = null)
    {
        $hash = md5($email);
        $customer = static::where('email_hash', $hash)->first();
        if (!$customer) {
            $name = $name ? $name : $email;
            $customer = static::create([
                'group_id' => 0,
                'store_id' => ShareBucket::get('store_id', 0),
                'name' => $name,
                'email' => $email,
                'email_hash' => $hash,
                'password' => bcrypt(Str::random(12)),
                'is_guest' => 1,
            ]);
        }
        return $customer;
    }

    public function guest()
    {
        return $this->is_guest;
    }

    public function isApi()
    {
        return false;
    }
}
