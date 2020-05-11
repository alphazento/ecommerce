<?php

namespace Zento\Customer\Mixins;

use Zento\Customer\Model\SessionGuest;

//for session auth guard

class AuthGuardGuest
{
    public function loadGuestUser()
    {
        return function () {
            $this->user = new SessionGuest();
            return $this->user;
        };
    }
}
