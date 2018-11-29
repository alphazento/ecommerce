<?php

namespace Zento\Catalog\Model;

use Illuminate\Support\Str;
use Zento\RouteAndRewriter\Model\UrlRewriteRule as RuleModel;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Catalog\Model\ORM\Product;

class ProductUrlRewriteEngine extends \Zento\RouteAndRewriter\Engine\UrlRewriteEngine
{
    public function findRewriteRule(string $url) {
        $product = Product::where('url_path', '=', $url)
            ->first(['id']);
    }
}