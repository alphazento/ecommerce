<?php

namespace Zento\SalesAdmin\Model\ORM;

use Zento\Customer\Model\ORM\Customer;
use Zento\Kernel\Booster\Database\Eloquent\QueryFilter;

class SalesOrder extends \Zento\Sales\Model\ORM\SalesOrder
{
    public $_richData_ = [
        'payment',
        'status',
        'status_history',
        'customer'
    ];

    public function customer() {
       return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}