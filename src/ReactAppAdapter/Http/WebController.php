<?php

namespace Zento\ReactAppAdapter\Http\Controllers;

use Route;
use Request;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;
use Illuminate\Http\JsonResponse;

class WebController extends \App\Http\Controllers\Controller
{
    public function appServe() {
        app()->instance('middleware.disable', true);
        $request = Request::create('/rest/v1/configs/reactapp', 'GET');
        $response = Route::dispatch($request);
        if ($response instanceof JsonResponse) {
            return $response->getOriginalContent();
        }
    }
}
