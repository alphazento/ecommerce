<?php

namespace Zento\Passport\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;
use Zento\Passport\Model\User;

class ApiAccessControlPolicy
{
    use HandlesAuthorization;

    public function apiRequest(User $user, Request $request)
    {
        return true;
    }
}
