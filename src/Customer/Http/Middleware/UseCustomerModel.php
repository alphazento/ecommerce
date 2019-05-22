<?php

namespace Zento\Customer\Http\Middleware;

use Closure;

use Request;
use Config;

class UseCustomerModel
{
    static $Model = \Zento\Customer\Model\ORM\Customer::class;
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
        Config::set('auth.providers.users.model', self::$Model);
        return $next($request);
    }
}