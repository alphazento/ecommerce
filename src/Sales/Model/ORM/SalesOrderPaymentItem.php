<?php

namespace Zento\Sales\Model\ORM;

use DB;
use Illuminate\Support\Collection;

class SalesOrderPaymentItem extends \Illuminate\Database\Eloquent\Model
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use \Zento\Kernel\Booster\Database\Eloquent\DA\TraitRealationMutatorHelper;

    public static function getPreloadRelations() {
        return [
            // 'relation',
            // 'withcount' => ['items']
        ];
    }

    // protected $fillable = self::PROPERTIES;
}