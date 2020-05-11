<?php

namespace Zento\Contracts\Interfaces;

interface IAddress extends \Zento\Contracts\AssertAbleInterface
{
    const PROPERTIES = [
        'name',
        'company',
        'address1',
        'address2',
        'city',
        'country',
        'postal_code',
        'state',
        'phone',
    ];
}
