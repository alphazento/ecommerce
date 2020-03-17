<?php

namespace Zento\Acl\Http\Middleware;

use Closure;
use ShareBucket;

class DisableAclCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $extras
     * @return mixed
     */
    public function handle($request, Closure $next, ...$extras)
    {
        ShareBucket::put('disable_acl_check', true);
        return $next($request);
    }
}
