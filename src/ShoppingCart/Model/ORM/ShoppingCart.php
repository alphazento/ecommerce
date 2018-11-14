<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCart extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\ShoppingCart
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public static function getPreloadRelations() {
        return [
            'billing_address',
            'shipping_address',
            'items',
            'withcount' => ['items']
        ];
    }

    protected $fillable = self::PROPERTIES;

    public function billing_address() {
        return $this->hasOne(ShoppingCartAddress::class, 'id', 'billing_address_id');
    }

    public function shipping_address() {
        return $this->hasOne(ShoppingCartAddress::class, 'id', $this->ship_to_billingaddesss ? 'billing_address_id' : 'shipping_address_id');
    }

    public function shipping_information() {
        // "shippingInformation": {
        //     "provider": null,
        //     "fees": 10,
        //     "method": "Fast custom shipping"
        //   },
    }

    public function summary()  {
        // "summary": {
        //     "subtotal": 20,
        //     "taxableTotal": 20,
        //     "total": 30,
        //     "paymentMethod": 0,
        //     "taxes": [],
        //     "adjustedTotal": 30
        //   },
    }

    // public function metadata() {

    // }

    public function items() {
        return $this->hasMany(ShoppingCartItem::class, 'cart_id');
    }
}