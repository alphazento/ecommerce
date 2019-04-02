<?php

namespace Zento\ReactApp\Http\Controllers;

use Route;
use Request;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Illuminate\Http\JsonResponse;

class WebController extends \App\Http\Controllers\Controller
{
    public function appServe() {
        $originRequest = Request::instance();

        app()->instance('middleware.disable', true);
        $data = [];
        $appConfigs = [];
        

        $request = Request::create('/rest/v1/configs/reactapp', 'GET');
        app()->instance('request', $request);
        $appConfigsResp = Route::dispatch($request);
        if ($appConfigsResp instanceof JsonResponse) {
            $appConfigs = $appConfigsResp->getOriginalContent();
        }

        $categories = [];
        $request = Request::create('/rest/v1/categories', 'GET');
        app()->instance('request', $request);
        $categoriesResp = Route::dispatch($request);
        if ($categoriesResp instanceof JsonResponse) {
            $categories = $categoriesResp->getOriginalContent();
        }
        $data = ['appconfigs' => $appConfigs['data'], 'categories' => $categories['data']];

        $url = Request::path();
        $urlRewrite = [];
        if ($url != '/') {
            $request = Request::create('/rest/v1/urlrewrite', 'GET', ['url' => $url]);
            app()->instance('request', $request);
            $resp = Route::dispatch($request);
            $respData = $resp->getOriginalContent();
            $respData['data'] = $respData['data']->toArray();

            $data['urlrw'] = [$url => $respData];
        } else {
            $data['urlrw'] = '';
        }
        app()->instance('request', $originRequest);
        return view('index', $data);
    }

    public function appServe1() {
        app()->instance('middleware.disable', true);
        $request = Request::create('/rest/v1/configs/reactapp', 'GET');
        $response = Route::dispatch($request);
        if ($response instanceof JsonResponse) {
            return $response->getOriginalContent();
        }
    }
}
