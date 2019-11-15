<?php

namespace Zento\Passport\Model;

use Illuminate\Support\Str;

class ApiGuest extends user {
    public function __construct(array $attrs = []) {
        parent::__construct($attrs);
        $this->is_guest = true;
        $this->attributes['id'] = $this->id ?? session()->getId();
    }

    public function save(array $options = []) {
        session()->put(self::STORE_KEY, $this->toArray());
        return $this;
    }

    public function getIdAttribute() {
        return $this->attributes['id'] ?? null;
    }
}