<?php

namespace Zento\SalesAdmin\Model\ORM;
use Zento\Customer\Model\ORM\Customer;

class SalesOrder extends \Zento\Sales\Model\ORM\SalesOrder
{
    public static function getPreloadRelations() {
        return [
            'payment',
            // 'shipment',
            'status',
            'status_history',
            'customer'
            // 'withcount' => ['items']
        ];
    }

   public function customer() {
       return $this->hasOne(Customer::class, 'id', 'customer_id');
   }
}