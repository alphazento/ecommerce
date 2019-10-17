<?php

namespace Zento\Customer\Mixins;
use Zento\Customer\Model\Guest;

class AuthGuard {
    public function guestUser() {
        return function() {
            $this->user = new Guest($this->session->get('guest_user', []));
            return $this->user;
        };
    }
}