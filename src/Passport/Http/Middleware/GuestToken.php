<?php

namespace Zento\Passport\Http\Middleware;

use ShareBucket;
use Zento\Passport\Mixins\RequestGuestToken;

class GuestToken
{
    const ALLOW_GUEST_API = 'ALLOW_GUEST_API';
    const RestrictMode = 'restrict'; //will noly return user when guest token in the request header
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next, $guestMode = 'restrict')
    {
        ShareBucket::put(self::ALLOW_GUEST_API, $guestMode);
        return $next($request);
    }

    /**
     * prepare a guest api user and api guest token if need
     * @param \Illuminate\Foundation\Auth\User  $user
     * @return void
     */
    public static function prepareGuestForApi($request)
    {
        if ($guestMode = ShareBucket::get(self::ALLOW_GUEST_API)) {
            $request->mixin(new RequestGuestToken());
            if ($token = $request->guestToken()) {
                return app()->make('\Zento\Passport\Model\PassportGuestUser',
                    ['attrs' => json_decode(decrypt($token), true)]);
            } else {
                if ($guestMode !== self::RestrictMode) {
                    return app()->make('\Zento\Passport\Model\PassportGuestUser');
                }
            }
        }
        return null;
    }
}
