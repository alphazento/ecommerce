<?php

namespace Zento\Acl;

class AclException extends \Illuminate\Auth\AuthenticationException
{
    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'User authed, but permission denied.')
    {
        parent::__construct($message);
    }
}
