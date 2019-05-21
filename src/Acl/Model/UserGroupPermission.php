<?php

namespace Zento\Acl\Model;

class GroupPermission extends ApcDbModel
{
    protected $fillable = [
        'group_id',
        'item_id'
    ];

    public function group() {
        return $this->belongsTo(UserGroup::class, 'id', 'group_id');
    }

    public function permission() {
        return $this->hasOne(PermissionItem::class, 'id', 'item_id');
    }
}
