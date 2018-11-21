<?php

namespace Zento\Passport\Http\Middleware;

use Closure;

use Request;
use Config;

class UsePassportUserModel
{
    public static $USER_MODEL = \Zento\Passport\Model\User::class;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // change auth setting for normal request
        Config::set('auth.providers.users.model', self::$USER_MODEL);
        return $next($request);
    }
}