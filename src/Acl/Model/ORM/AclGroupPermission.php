<?php

namespace Zento\Acl\Model\ORM;

class AclRoleRoute extends AclBaseModel
{
    protected $fillable = [
        'scope',
        'group_id',
        'item_id'
    ];

    public function group() {
        return $this->belongsTo(AclRole::class, 'id', 'group_id');
    }

    public function permission() {
        return $this->hasOne(AclRoute::class, 'id', 'item_id');
    }
}
