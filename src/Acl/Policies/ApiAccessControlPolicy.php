<?php

namespace Zento\Acl\Policies;

use Illuminate\Http\Request;
use Zento\Acl\Exceptions\AclException;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Passport\Model\User;

class ApiAccessControlPolicy extends \Zento\Passport\Policies\ApiAccessControlPolicy
{
    public function apiRequest(User $user, Request $request)
    {
        if (!Acl::checkRequest($request, $user)) {
            throw new AclException();
        }
    }
}
