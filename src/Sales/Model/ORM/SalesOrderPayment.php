<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderPayment extends \Illuminate\Database\Eloquent\Model #implements \Zento\Contracts\Catalog\Model\ShoppingCart
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    public static function getPreloadRelations() {
        return [
            "items",
            'withcount' => ['items']
        ];
    }

    // protected $fillable = self::PROPERTIES;

    public function items() {
        return $this->hasMany(SalesOrderPaymentItem::class, 'payment_id');
    }
}