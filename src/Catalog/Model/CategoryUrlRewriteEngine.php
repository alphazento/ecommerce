<?php

namespace Zento\Catalog\Model;

use Illuminate\Support\Str;
use Zento\RouteAndRewriter\Model\UrlRewriteRule as RuleModel;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\Catalog\Model\ORM\Category;

class CategoryUrlRewriteEngine extends \Zento\RouteAndRewriter\Engine\UrlRewriteEngineAbstract
{
    public function findRewriteRule(string $url) {
        if ($category = Category::where('url_path', '=', $url)
                ->first(['id'])) {
            $rule = new RuleModel();
            $rule->req_uri = $url;
            $rule->to_uri = '/category/' . $category->id;
            $rule->status_code = 200;
            return $rule;
        }
        return false;
    }
}