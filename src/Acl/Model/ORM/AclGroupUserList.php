<?php

namespace Zento\Acl\Model\ORM;

use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;

class AclGroupUserList extends AclBaseModel
{
    protected $fillable = [
        'user_scope',
        'user_id',
        'group_id'
    ];

    public function customers() {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function administators() {
        return $this->belongsTo(Administrator::class, 'user_id', 'id');
    }
}
