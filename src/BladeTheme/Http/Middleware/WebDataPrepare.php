<?php

namespace Zento\BladeTheme\Http\Middleware;

use Closure;
use ShareBucket;
use ProductService;
use Zento\BladeTheme\Facades\BladeTheme;

class WebDataPrepare
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
        if (!$request->ajax()) {
            $bladeTheme = BladeTheme::breadcrumb('/', 'Home');
            BladeTheme::addGlobalViewData(['consts' => []]);
            $this->prepareApiGuestToken($request->user());
            $swatches = ProductService::getProductSwatches();
            $bladeTheme->addGlobalViewData(compact('swatches'))
                ->preRouteCallAction()
                ->shareViewData();
        }
        
        return $next($request);
    }

    protected function prepareApiGuestToken($user) {
        if (env('API_GUEST_TOKEN_ENABLED')) {
            $apiGuestToken = BladeTheme::getApiGuestToken($user);
            BladeTheme::addGlobalViewData(compact('apiGuestToken'));
            return $apiGuestToken;
        }
    }
}