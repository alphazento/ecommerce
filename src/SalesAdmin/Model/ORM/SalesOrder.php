<?php

namespace Zento\SalesAdmin\Model\ORM;

use Zento\Customer\Model\ORM\Customer;
use Zento\Kernel\Booster\Database\Eloquent\QueryFilter;

class SalesOrder extends \Zento\Sales\Model\ORM\SalesOrder
{
    public $_richData_ = [
        'payments',
        'status_history',
        'customer',
        'shipments',
        'admin_comments.administrator'
    ];

    public function customer() {
       return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function admin_comments() {
        return $this->hasMany(AdminComment::class, 'order_id', 'id')
            ->where('type_id', '=', AdminComment::ADMIN_NOTE)
            ->orderBy('updated_at', 'desc');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public function status_history() {
        return $this->hasMany(SalesOrderStatusHistory::class, 'order_id');
    }
}