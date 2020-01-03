<?php

namespace Zento\SalesAdmin\Model\ORM;

use Zento\Backend\Model\ORM\Administrator;

class AdminComment extends \Illuminate\Database\Eloquent\Model
{
    // fields
    // admin_id
    // order_id
    // comment
    // notify_to_customer
    // created_at
    // updated_at

    public function administrator() {
       return $this->hasOne(Administrator::class, 'id', 'admin_id');
    }
}