<?php

namespace Zento\Acl\Exceptions;

class AclException extends \Illuminate\Auth\AuthenticationException
{
    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'ACL Denied')
    {
        parent::__construct($message);
    }
}
