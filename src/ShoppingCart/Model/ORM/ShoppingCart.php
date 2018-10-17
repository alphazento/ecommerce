<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCart extends \Illuminate\Database\Eloquent\Model implements \Zento\Contracts\Catalog\Model\ShoppingCart
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public static $preload_relations = [
        'billing_address',
        'shipping_address',
        'items',
        'withcount' => ['items']
    ];

    protected $fillable = [
        'email',
        'customer_id',
        'store_id',
        'applied_rule_ids',
        'client_ip',
        'mode',   //test, stag, live
        'status',
        'ship_to_billingaddesss', //boolean,
        'billing_address_id',
        'shipping_address_id',
        'invoice_number',
        'payment_method',
        "currency",
        "total_weight",
        "total",
        'grand_total',
        'subtotal',
        'subtotal_with_discount'
    ];

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