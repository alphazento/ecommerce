<?php

namespace Zento\Acl\Model\ORM;

use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;

class AclRoleUser extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'user_id',
        'group_id'
    ];

    public function customers() {
        return $this->belongsTo(Customer::class, 'user_id', 'id');
    }

    public function administrators() {
        return $this->belongsTo(Administrator::class, 'user_id', 'id');
    }
}
