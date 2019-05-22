<?php

namespace Zento\Acl\Model\Auth\Backend;

class UserProvider extends \App\Backend\Model\Auth\UserProvider
{
    protected $userModel = User::class;
}
