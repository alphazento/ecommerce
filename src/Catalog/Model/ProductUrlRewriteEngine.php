<?php

namespace Zento\Catalog\Model;

use Illuminate\Support\Str;
use Zento\Catalog\Model\ORM\Product;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\RouteAndRewriter\Model\UrlRewriteRule as RuleModel;

class ProductUrlRewriteEngine extends \Zento\RouteAndRewriter\Engine\UrlRewriteEngineAbstract
{
    public function findRewriteRule(string $url)
    {
        $url = Str::endsWith($url, '.html') ? substr($url, 0, -5) : $url;
        if ($product = Product::where('url_key', '=', $url)
            ->first(['id'])) {
            $rule = new RuleModel();
            $rule->req_uri = $url;
            // $rule->to_uri = '/product/' . $product->id;
            $rule->to_uri = RouteAndRewriterService::buildToUri('product', $product->id);
            $rule->status_code = 200;
            return $rule;
        }
        return false;
    }
}
