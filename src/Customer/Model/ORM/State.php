<?php

namespace Zento\Customer\Model\ORM;

class State extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $fillable = [
        'country_alpha2_code',
        'code',
        'name',
    ];
}
