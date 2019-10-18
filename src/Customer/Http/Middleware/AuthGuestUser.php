<?php

namespace Zento\Customer\Http\Middleware;

use Auth;
use Closure;
use Zento\Kernel\Facades\ShareBucket;
use Zento\Customer\Mixins\AuthGuard;

class AuthGuestUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next) {
        if (!Auth::user()) {
            Auth::mixin(new \Zento\Customer\Mixins\AuthGuardGuest);
            Auth::loadGuestUser();
        }
        return $next($request);
    }
}
