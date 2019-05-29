<?php

namespace Zento\Acl\Model\ORM;

class AclGroupPermission extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'group_id',
        'item_id'
    ];

    public function group() {
        return $this->belongsTo(AclUserGroup::class, 'id', 'group_id');
    }

    public function permission() {
        return $this->hasOne(AclPermissionItem::class, 'id', 'item_id');
    }
}
