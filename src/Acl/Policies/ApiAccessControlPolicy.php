<?php

namespace Zento\Acl\Policies;

use Zento\Passport\Model\User;
use Zento\Acl\Providers\Facades\Acl;
use Zento\Acl\Exceptions\AclException;

use Illuminate\Http\Request;

class ApiAccessControlPolicy extends \Zento\Passport\Policies\ApiAccessControlPolicy
{
    public function apiRequest(User $user, Request $request) {
        if (!Acl::checkRequest($request, $user)) {
            throw new AclException();
        }
    } 
}
