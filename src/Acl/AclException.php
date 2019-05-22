<?php

namespace Zento\Acl;

use Exception;

class AclException extends Exception
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
