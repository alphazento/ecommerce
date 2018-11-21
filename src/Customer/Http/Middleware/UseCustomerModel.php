<?php

namespace Zento\Customer\Http\Middleware;

use Closure;

use Request;
use Config;

class UseCustomerModel
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
        \Zento\Passport\Http\Middleware\UsePassportUserModel::$USER_MODEL = \Zento\Customer\Model\ORM\Customer::class;
        return $next($request);
    }
}