<?php

namespace Zento\Contracts;

interface Address extends \Zento\Contracts\AssertAbleInterface 
{
    const PROPERTIES = [
        'firstname', 
        'lastname', 
        'company',
        'address1', 'address2',  
        'city', 
        'country', 'postal_code', 
        'state', 
        'phone'
    ];
}