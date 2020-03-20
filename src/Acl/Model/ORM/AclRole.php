<?php

namespace Zento\Acl\Model\ORM;

class AclRole extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'name',
        'description',
        'active'
    ];

    /**
     * Undocumented function
     *
     * @return Collection of AdminPermissionItem
     */
    public function permissions() {
        return $this->hasManyThrough(AclRoute::class, AclRoleRoute::class,
            'group_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function groupusers() {
        return $this->hasMany(AclRoleUser::class, 'group_id', 'id');
    }
}
