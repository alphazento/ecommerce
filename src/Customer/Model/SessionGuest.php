<?php

namespace Zento\Customer\Model;

class SessionGuest extends ORM\Customer
{
    const STORE_KEY = 'guest_user';
    public function __construct(array $attrs = [])
    {
        $attrs = session()->get(self::STORE_KEY, []);
        parent::__construct($attrs);
        $this->is_guest = true;
        $this->attributes['id'] = $this->id ?? session()->getId();
    }

    public function save(array $options = [])
    {
        session()->put(self::STORE_KEY, $this->toArray());
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
}
