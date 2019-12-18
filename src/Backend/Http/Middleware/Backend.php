<?php

namespace Zento\Backend\Http\Middleware;

use Closure;

use Request;
use Config;
use ShareBucket;
use Zento\Passport\Passport;
use Zento\Passport\NotUsingPassportException;

class Backend
{
    const BACKEND_IP_RESTRICT = 'backend.ip.restrict';
    const BACKEND_IP_ALLOWLIST = 'backend.ip.allowlist';
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Passport::setPassportUserModel(\Zento\Acl\Model\Auth\Administrator::class);
        ShareBucket::put(\Zento\Kernel\Consts::ZENTO_PORTAL, 'admin');
        //change default setting as admin setting

        if (config(self::BACKEND_IP_RESTRICT)
            && $this->checkIp($request)) {
            return response(sprintf('IP %s is not allowed to access admin.', $request->ip()), 401);
        }
        return $next($request);
    }

    protected function checkIp($request)
    {
        return false;
        $restrict = true;
        $ipAllows = config(self::BACKEND_IP_ALLOWLIST, false);
        if ($ipAllows) {
            $ipAllows = explode(';', $ipAllows);
            $ipAllows = array_map(function($v) {
                $ip = explode('#', $v);
                return trim($ip[0]);
            }, $ipAllows);
            if (in_array($request->ip(), $ipAllows)) {
                $restrict = false;
            }
        }
        return $restrict;
    }
}