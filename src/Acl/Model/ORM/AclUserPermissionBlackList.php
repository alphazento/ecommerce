<?php

namespace Zento\Acl\Model\ORM;

class AclUserPermissionBlackList extends AclBaseModel
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];
}
