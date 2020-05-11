<?php

namespace Zento\Sales\Model\ORM;

use Illuminate\Support\Arr;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;

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

    public static function createFromCart(IShoppingCart $cart)
    {
        $shipping_address = $cart->shipping_address;
        if (!$shipping_address) {
            $shipping_address = ShoppingCartAddress::find($cart->shipping_address_id);
        }
        if ($shipping_address) {
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
        return null;
    }

    protected function hashRecord()
    {
        $attrs = Arr::only($this->attributes, $this->fillable);
        return md5(implode(',', $attrs));
    }
}
