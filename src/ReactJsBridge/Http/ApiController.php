<?php

namespace Zento\ReactJsBridge\Http\Controllers;

use Route;
use Request;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;

class ApiController extends \App\Http\Controllers\Controller
{
    protected $recursive_level = 0;

    public function configs() {
        $data = [
            'swatches' => [],
        ];

        return ['status' => 200, 'data' => $data];
    }

    public function getUrlRewriteTo(\Illuminate\Http\Request $request) {
        RouteAndRewriterService::setUriBuilder('category', function($id) {
            return sprintf('/category/%s', $id);
        });
        RouteAndRewriterService::setUriBuilder('product', function($id) {
            return sprintf('/product/%s', $id);
        });
        
        if ($rule = $this->recursiveFindRewriteRule($request->get('url'))) {
            return [
                'status'=>200, 
                'data'=>$rule
            ];
        }
        return ['status'=>404, 'data'=>null];
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @return RewriteRule|false
     */
    protected function recursiveFindRewriteRule(string $url) {
        if ($this->recursive_level++ > 5) {
            return false;
        }
        if ($rule = RouteAndRewriterService::findRewriteRule($url)) {
            if ($rule->status_code == 200) {
                return $rule;
            } elseif ($rule->status_code == 301 || $rule->status_code == 302) {
                return $this->findRewriteRule($rule->to_uri);
            }
        }
        return false;
    }
}