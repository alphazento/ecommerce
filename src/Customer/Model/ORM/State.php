<?php

namespace Zento\Customer\Model\ORM;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class State extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $fillable = [
        'country_alpha2_code',
        'code',
        'name'
    ];
}
