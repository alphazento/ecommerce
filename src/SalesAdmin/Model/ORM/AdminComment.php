<?php

namespace Zento\SalesAdmin\Model\ORM;

use Zento\Backend\Model\ORM\Administrator;

class AdminComment extends \Illuminate\Database\Eloquent\Model
{
    // fields:
    // type
    // admin_id
    // order_id
    // comment
    // notify_to_customer
    // created_at
    // updated_at
    const ADMIN_NOTE = 1;
    const ORDER_STATUS_CHANGE = 2;
    const PAYMENT_STATUS_CHANGE = 3;
    const ADDRESS_CHANGE = 4;

    protected $fillable = [
        'type_id',
        'admin_id',
        'order_id',
        'comment',
        'notify_to_customer'
    ];

    public function administrator() {
       return $this->hasOne(Administrator::class, 'id', 'admin_id');
    }
}