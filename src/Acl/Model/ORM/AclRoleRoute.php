<?php

namespace Zento\Acl\Model\ORM;

class AclRoleRoute extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'role_id',
        'route_id'
    ];

    public function group() {
        return $this->belongsTo(AclRole::class, 'id', 'role_id');
    }

    public function permission() {
        return $this->hasOne(AclRoute::class, 'id', 'route_id');
    }
}
