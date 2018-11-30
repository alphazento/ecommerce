<?php

namespace Zento\Catalog\Model;

use Illuminate\Support\Str;
use Zento\RouteAndRewriter\Model\UrlRewriteRule as RuleModel;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Catalog\Model\ORM\Product;

class ProductUrlRewriteEngine extends \Zento\RouteAndRewriter\Engine\UrlRewriteEngineAbstract
{
    public function findRewriteRule(string $url) {
        if ($product = Product::where('url_path', '=', $url)
            ->first(['id'])) {
            $rule = new RuleModel();
            $rule->to_uri = '/product/' . $product->id;
            $rule->status_code = 200;
            return $rule;
        }
        return false;
    }
}