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
            $origin = $request->header('origin') ?: $request->url();
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Headers', 'origin, content-type, accept, authorization, Access-Control-Allow-Origin');
            $response->header('Access-Control-Allow-Methods', 'GET, HEAD, OPTIONS, POST, PATCH, DELETE');
            $response->header('Access-Control-Allow-Credentials', 'true');
            });
    }
}
