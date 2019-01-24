<?php

namespace Zento\ReactJsBridge\Http\Controllers;

use Route;
use Request;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class ApiController extends \App\Http\Controllers\Controller
{
    protected $recursive_level = 0;

    public function configs() {
        $data = [
            'swatches' => $this->getProductSwatches(),
            'reorder' => [],
            'constants' => []
        ];

        return ['status' => 200, 'data' => $data];
    }

    protected function getProductSwatches() {
        $attributes = DynamicAttribute::with(['options'])
            ->where('swatch_type', '>', '0')
            ->where('enabled', 1)
            ->get();
        
        $results = [];
        foreach($attributes as $attr) {
            $options = [];
            foreach($attr->options as $option) {
                $options[$option->value] = $option->swatch_value;
            }
            $results[$attr->attribute_name] = $options;
        }
        return $results;
    }

    /**
     * provide reactjs url rewrite support
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
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