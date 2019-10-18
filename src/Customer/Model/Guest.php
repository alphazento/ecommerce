<?php

namespace Zento\Customer\Model;

class Guest extends ORM\Customer {
    public function __construct(array $attrs) {
        $this->is_guest = true;
        $this->email = $attrs['e'] ?? session()->getId();
        $this->guest_email = $this->email;
        $this->id = $attrs['i'] ?? 0;
    }

    public function save(array $options = []) {
        return $this;
    }
}