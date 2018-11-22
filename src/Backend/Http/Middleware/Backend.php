<?php

namespace Zento\Backend\Http\Middleware;

use Closure;

use Request;
use Config;

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
        //change default setting as admin setting
        if (Request::segment(1) == Store::getConfig('backend_url_prefix')) {
            if (config(self::BACKEND_IP_RESTRICT)
             && $this->checkIp($request)) {
                return response(sprintf('IP %s is not allowed to access backedn.', $request->ip()), 401);
            }

            // change auth setting for normal request
            Config::set('session.cookie', Config::get('session.cookie') . '_backend');
            // Config::set('auth.providers.users.model', \Zento\Backend\Model\ORM\Customer::class);
            // \Zento\Passport\Passport::$USER_MODEL = \Zento\Backend\Model\User::class;
        }
        
        return $next($request);
    }

    protected function checkIp($request)
    {
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