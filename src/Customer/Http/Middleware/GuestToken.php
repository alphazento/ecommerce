<?php

namespace Zento\Customer\Http\Middleware;

use Closure;
use DB;

class GuestToken extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $default = DB::getDefaultConnection();
        //change db connection
        try {
            $this->authenticate($request, ['api']);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
        }
        //restore DB connection
        DB::setDefaultConnection($default);
        return $next($request);
    }
}
