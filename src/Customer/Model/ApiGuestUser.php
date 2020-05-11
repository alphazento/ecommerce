<?php

namespace Zento\Customer\Model;

use Illuminate\Support\Str;

class ApiGuestUser extends ORM\Customer
{
    public function __construct(array $attrs = [])
    {
        parent::__construct($attrs);
        $this->is_guest = true;
        $this->attributes['id'] = $attrs['id'] ?? Str::uuid();
    }

    public function save(array $options = [])
    {
        return $this;
    }

    public function getIdAttribute()
    {
        return $this->attributes['id'] ?? null;
    }

    public function guest()
    {
        return true;
    }

    public function isApi()
    {
        return true;
    }
}
