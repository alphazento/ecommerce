<?php

namespace Zento\Passport\Http\Middleware;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        return tap($next($request), function ($response) use ($request) {
            $origin = $request->header('origin') ?: $request->server('HTTP_ORIGIN');
            $response->header('Access-Control-Allow-Origin', $origin);
            //guest-uuid is a customize heaer
            $response->header('Access-Control-Allow-Headers', 'origin, content-type, accept, authorization, guest-uuid, Access-Control-Allow-Origin');
            $response->header('Access-Control-Allow-Methods', 'GET, PUT, HEAD, OPTIONS, POST, PATCH, DELETE');
            $response->header('Access-Control-Allow-Credentials', 'true');
        });
    }
}
