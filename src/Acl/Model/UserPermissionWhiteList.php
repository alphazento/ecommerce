<?php

namespace Zento\Acl\Model;

class UserPermissionWhiteList extends ApcDbModel
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];
}
