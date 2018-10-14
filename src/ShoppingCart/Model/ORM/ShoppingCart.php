<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\HasManyInAggregatedField;

class ShoppingCart extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
 
    public static $preload_relations = [
        'items',
        'billing_address',
        'shipping_address',
        'withcount' => ['items']
    ];


    protected $fillable = [
        'guid',
        'email',
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
        
    ];

    // {
    //     "discounts": [],
    //     "customFields": [],
    //     "plans": [],
    //     "refunds": [],
    // }

    public function billing_address() {
        return $this->hasOne(Address::class, 'id', 'billing_address_id');
    }

    public function shipping_address() {
        return $this->hasOne(Address::class, 'id', $this->ship_to_billingaddesss ? 'billing_address_id' : 'shipping_address');
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

    public function metadata() {

    }

    public function items() {
        return $this->hasMany(ShoppingCartItem::class, 'cart_guid', 'guid');
    }
}