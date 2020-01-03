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
        'customer',
        'admin_comments'
    ];

    public function customer() {
       return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function admin_comments() {
        return $this->hasMany(AdminComment::class, 'order_id', 'id')
            ->orderBy('updated_at', 'desc');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}