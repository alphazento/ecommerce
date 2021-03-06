<?php

namespace Zento\Acl\Model\ORM;

class AclRole extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'name',
        'description',
        'active',
    ];

    /**
     * Undocumented function
     *
     * @return Collection of AdminPermissionItem
     */
    public function routes()
    {
        return $this->hasManyThrough(AclRoute::class, AclRoleRoute::class,
            'role_id',
            'id',
            'id',
            'route_id'
        );
    }

    public function users()
    {
        return $this->hasMany(AclRoleUser::class, 'role_id', 'id');
    }
}
