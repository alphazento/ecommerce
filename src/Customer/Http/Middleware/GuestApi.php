<?php

namespace Zento\Customer\Http\Middleware;

use Closure;
use DB;

class GuestApi extends \Illuminate\Auth\Middleware\Authenticate
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
        // DB::setDefaultConnection('tony');
        try {
          $this->authenticate($request, ['api']);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
          $customer = \Zento\Customer\Model\ORM\Customer::createDummyCustomer();
        }
        //restore DB connection
        DB::setDefaultConnection($default);
        return $next($request);
    }
}