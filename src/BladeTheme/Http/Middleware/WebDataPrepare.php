<?php

namespace Zento\BladeTheme\Http\Middleware;

use Closure;
use ProductService;
use Zento\BladeTheme\Consts;
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
            $attrContainers = ProductService::getProductAttrContainers();
            $bladeTheme->addGlobalViewData(compact('attrContainers'))
                ->preRouteCallAction()
                ->shareViewData();
        }

        return $next($request);
    }

    protected function prepareApiGuestToken($user)
    {
        $apiGuestToken = config(Consts::WORK_WITH_PASSPORT_GUEST_TOKEN) ? BladeTheme::getApiGuestToken($user) : null;
        BladeTheme::addGlobalViewData(compact('apiGuestToken'));
        return $apiGuestToken;
    }
}
