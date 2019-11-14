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
        $guest = !Auth::user();
        if ($guest) {
            Auth::mixin(new \Zento\Customer\Mixins\AuthGuardGuest);
            Auth::loadGuestUser();
        }
        $response = $next($request);
        if ($guest) {
            Auth::user()->save();
        }
        return $response;
    }
}
