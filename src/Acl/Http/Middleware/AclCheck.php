<?php

namespace Zento\Acl\Http\Middleware;

use ACL;
use Closure;

class PermissionCheck
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
        if (!$this->isException($request)) {
            if (!ACL::checkRequest($request)) {
                return response('Permission required. Please contact admininistator to get permission.', 401);
            }
        }

        return $next($request);
    }

    protected function isException($request) {
        $exceptions = [
            sprintf('POST:%s', '/oauth/token'),
            sprintf('POST:%s', '/oauth/token/google'),
            sprintf('GET:%s', '/oauth/token/user')
        ];

        $req = sprintf('%s:/%s', $request->method(), $request->path());
        return in_array($req, $exceptions);
    }
}
