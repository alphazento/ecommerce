<?php

namespace Zento\Acl\Model\Auth;

class UserProvider extends \App\Backend\Model\Auth\UserProvider
{
    protected $userModel = User::class;
}
