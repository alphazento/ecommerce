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
        
        $request = Request::create('/rest/v1/reactapp/configs', 'GET');
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
        $data = [
            "server" => config('app.url'), //url('/),
            "image_server" => config('app.url') . '/images/catalog', //url('/images/catalog'),
            'configs' => $appConfigs['data'], 
            'categories' => $categories['data']
        ];

        $url = Request::path();
        $urlRewrite = [];
        if ($url != '/') {
            $request = Request::create('/rest/v1/urlrewrite', 'GET', ['url' => $url]);
            app()->instance('request', $request);
            $resp = Route::dispatch($request);
            $respData = $resp->getOriginalContent();
            $respData['data'] = $respData['data'] ? $respData['data']->toArray() : null;

            $data['urlrw'] = [$url => $respData];
        } else {
            $data['urlrw'] = '';
        }

        // $pageconfigs = [];
        // $request = Request::create('/rest/v1/pageconfigs', 'GET');
        // app()->instance('request', $request);
        // $resp = Route::dispatch($request);
        // if ($resp instanceof JsonResponse) {
        //     $pageconfigs = $resp->getOriginalContent();
        // }

        // $data = ['configs' => $appConfigs['data'], 'categories' => $categories['data']];

        app()->instance('request', $originRequest);
        return view('index', ['data' => $data]);
    }
}
