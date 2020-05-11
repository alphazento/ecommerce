<?php

namespace Zento\Acl\Model\ORM;

class AclBlackList extends AclBaseModel
{
    protected $fillable = [
        'user_id',
        'route_id',
    ];
}
