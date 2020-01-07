<?php

namespace Zento\Customer\Model\ORM;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Country extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'alpha2_code',
        'alpha3_code',
        'frontstore_active',
        'backend_active',
    ];

    public function states() {
        return $this->hasMany(State::class, 'country_alpha2_code', 'alpha2_code');
    }
}
