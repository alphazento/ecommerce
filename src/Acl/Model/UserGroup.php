<?php

namespace Zento\Acl\Model;

class UserGroup extends ApcDbModel
{
    protected $fillable = [
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
        return $this->hasManyThrough(PermissionItem::class, GroupPermission::class,
            'group_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function groupusers() {
        return $this->hasMany(GroupUserList::class, 'group_id', 'id');
    }
}
