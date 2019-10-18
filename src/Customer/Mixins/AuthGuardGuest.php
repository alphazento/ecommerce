<?php

namespace Zento\Customer\Mixins;
use Zento\Customer\Model\Guest;

class AuthGuardGuest {
    public function loadGuestUser() {
        return function() {
            $this->user = new Guest($this->session->get('guest_user', []));
            return $this->user;
        };
    }
}