<?php

namespace Zento\ShoppingCart\Http\Controllers\Api;


use Route;
use Request;
use Response;
use Registry;
use Product;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TestController extends \App\Http\Controllers\Controller
{
    public function getUrlRewrite() {
        $url = Request::get('url');
        switch($url) {
            case '/any-4-brother-lc47-compatible-inkjet-combo-p-4584.html':
            return ['status' => 200, 'data' => ['url' => $url, 'component' => 'product']];
            break;
            case '/any-4-brother-lc47-compatible-inkjet-combo-p-4583.html':
            return ['status' => 200, 'data' => ['url' => $url, 'component' => 'category']];
            break;
        }
        return ['status' => 404];
    }
}