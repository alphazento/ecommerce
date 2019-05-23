<?php

namespace Zento\Acl\Model\ORM;

class AclUserGroup extends AclBaseModel
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
        return $this->hasManyThrough(AclPermissionItem::class, AclGroupPermission::class,
            'group_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function groupusers() {
        return $this->hasMany(AclGroupUserList::class, 'group_id', 'id');
    }
}
