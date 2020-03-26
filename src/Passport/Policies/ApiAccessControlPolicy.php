<?php

namespace Zento\Passport\Policies;

use Zento\Passport\Model\User;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiAccessControlPolicy
{
    use HandlesAuthorization;

    public function apiRequest(User $user, Request $request) {
        return true;
    }
}
