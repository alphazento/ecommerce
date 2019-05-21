<?php

namespace Zento\Acl\Model\Auth;

class UserProvider extends \Inkstation\Admin\Model\Auth\UserProvider
{
    protected $userModel = User::class;
}
