<?php

namespace Zento\Acl\Model;

class UserPermissionBlackList extends ApcDbModel
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];
}
