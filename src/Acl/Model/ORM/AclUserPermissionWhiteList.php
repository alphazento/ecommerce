<?php

namespace Zento\Acl\Model\ORM;

class AclWhiteList extends AclBaseModel
{
    protected $fillable = [
        'user_id',
        'item_id'
    ];
}
