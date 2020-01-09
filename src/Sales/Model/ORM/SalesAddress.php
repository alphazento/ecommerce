<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Zento\Customer\Model\ORM\CustomerAddress;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

class SalesAddress extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'name',
        'company',
        'address1',
        'address2',
        'city',
        'country',
        'postal_code',
        'state',
        'phone',
    ];

    public static function createFromCart(IShoppingCart $cart) {
        $shipping_address = $cart->shipping_address;
        if (!$shipping_address) {
            $shipping_address = CustomerAddress::find($cart->shipping_address_id);
        }
        $address = new static();
        $attrs = Arr::only($shipping_address->toArray(), $address->fillable);
        $address->fill($attrs);
        $hash = $address->hashRecord();
        if ($record = static::where('hash', '=', $hash)->first()) {
            return $record;
        }
        $address->hash = $hash;
        $address->save();
        return $address;
    }

    protected function hashRecord() {
        $attrs = Arr::only($this->attributes, $this->fillable);
        return md5(implode(',', $attrs));
    }
}