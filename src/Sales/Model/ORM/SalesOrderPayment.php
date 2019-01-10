<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderPayment extends \Illuminate\Database\Eloquent\Model implements \Zento\PaymentGateway\Interfaces\PaymentDetail
{
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DynamicAttribute\TraitRealationMutatorHelper;

    protected $fillable = self::PROPERTIES;

    public static function getPreloadRelations() {
        return [
            "items",
            'withcount' => ['items']
        ];
    }

    public function items() {
        return $this->hasMany(SalesOrderPaymentItem::class, 'payment_id');
    }
}