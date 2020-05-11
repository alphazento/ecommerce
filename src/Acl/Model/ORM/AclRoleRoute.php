<?php

namespace Zento\Acl\Model\ORM;

class AclRoleRoute extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'role_id',
        'route_id',
    ];

    public function role()
    {
        return $this->belongsTo(AclRole::class, 'id', 'role_id');
    }

    public function route()
    {
        return $this->hasOne(AclRoute::class, 'id', 'route_id');
    }
}
