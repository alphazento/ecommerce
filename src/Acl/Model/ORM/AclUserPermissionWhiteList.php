<?php

namespace Zento\Acl\Model\ORM;

class AclUserPermissionWhiteList extends AclBaseModel
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];
}
