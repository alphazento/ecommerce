<?php

namespace Zento\Acl\Model;

class GroupUserList extends ApcDbModel
{
    protected $fillable = [
        'user_id',
        'group_id'
    ];

    public function user() {
        return $this->belongsTo(Auth\User::class, 'user_id', 'id');
    }
}
