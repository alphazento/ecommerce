<?php

namespace Zento\Backend\Http\Middleware;

use Closure;

use Request;
use Config;

class UseAdministratorModel
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
        Config::set('auth.providers.users.model', \Zento\Backend\Model\ORM\Administrator::class);
        return $next($request);
    }
}