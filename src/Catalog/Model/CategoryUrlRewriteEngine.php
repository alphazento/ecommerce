<?php

namespace Zento\Catalog\Model;

use Illuminate\Support\Str;
use Zento\Catalog\Model\ORM\Category;
use Zento\RouteAndRewriter\Facades\RouteAndRewriterService;
use Zento\RouteAndRewriter\Model\UrlRewriteRule as RuleModel;

class CategoryUrlRewriteEngine extends \Zento\RouteAndRewriter\Engine\UrlRewriteEngineAbstract
{
    public function findRewriteRule(string $url)
    {
        $url = Str::endsWith($url, '.html') ? substr($url, 0, -5) : $url;
        if ($category = Category::where('url_key', '=', $url)
            ->first(['id'])) {
            $rule = new RuleModel();
            $rule->req_uri = $url;
            // $rule->to_uri =  '/category/' . $category->id;
            $rule->to_uri = RouteAndRewriterService::buildToUri('category', $category->id);
            $rule->status_code = 200;
            return $rule;
        }
        return false;
    }
}
