<?php

namespace Zento\Passport\Http\Middleware;

use Closure;

use Request;
use Config;

class UsePassportUserModel
{
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
        Config::set('auth.providers.users.model', \Zento\Passport\Model\User::class);
        return $next($request);
    }
}