<?php

namespace Zento\Passport;

class NotUsingPassportException extends \Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'auth.api is not using passport as driver. Please config check auth.guards.api.driver')
    {
        parent::__construct($message);
    }
}
