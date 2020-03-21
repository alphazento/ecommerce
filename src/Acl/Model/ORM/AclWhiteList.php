<?php

namespace Zento\Acl\Model\ORM;

class AclWhiteList extends AclBaseModel
{
    protected $fillable = [
        'user_id',
        'route_id'
    ];
}
