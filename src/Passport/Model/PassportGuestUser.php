<?php

namespace Zento\Passport\Model;

use Illuminate\Support\Str;

class PassportGuestUser extends user {
    public function __construct(array $attrs = []) {
        parent::__construct($attrs);
        $this->is_guest = true;
        $this->attributes['id'] = $attrs['id'] ?? Str::uuid();
    }

    public function save(array $options = []) {
        return $this;
    }

    public function getIdAttribute() {
        return $this->attributes['id'] ?? null;
    }
}