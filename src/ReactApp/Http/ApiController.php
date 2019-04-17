<?php

namespace Zento\ReactApp\Http\Controllers;

use Route;
use Request;
use ProductService;
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

    public function cmsHome() {
        $jsonStr = '{"Carousel": [
            {
              "href": "/promotions/pants-all.html",
              "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-pants.jpg",
              "title": "20% OFF",
              "button": "View"
            },
            {
              "href": "/promotions/tees-all.html",
              "image":
                "https://magento.r.worldssl.net/media/wysiwyg/home/home-t-shirts.png",
              "title": "Even more ways to mix and match",
              "button": "View"
            },
            {
              "href": "/collections/erin-recommends.html",
              "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-erin.jpg",
              "title": "Take it from Erin",
              "button": "View"
            }
        ],
        "ImageSection":{
            "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-main.jpg",
            "title": "New Luma Yoga Collection",
            "description": "Get fit and look fab in new seasonal styles",
            "button": "Shop New Yoga",
            "href": "to"
          },
        "Gallery": [
            {
              "href": "/promotions/pants-all.html",
              "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-pants.jpg",
              "title": "20% OFF",
              "width": "50%"
            },
            {
              "href": "/promotions/tees-all.html",
              "image":
                "https://magento.r.worldssl.net/media/wysiwyg/home/home-t-shirts.png",
              "title": "Even more ways to mix and match",
              "width": "50%"
            },
            {
              "href": "/collections/erin-recommends.html",
              "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-erin.jpg",
              "title": "Take it from Erin",
              "width": "34%"
            },
            {
              "href": "/collections/performance-fabrics.html",
              "image":
                "https://magento.r.worldssl.net/media/wysiwyg/home/home-performance.jpg",
              "title": "Science meets performance",
              "width": "32%"
            },
            {
              "href": "/collections/eco-friendly.html",
              "image": "https://magento.r.worldssl.net/media/wysiwyg/home/home-eco.jpg",
              "title": "Twice around, twice as nice",
              "width": "34%"
            }
          ]}';

          $data = json_decode($jsonStr, true);
          $topSellerProducts = ProductService::getBestSellerProducts(10);
          if ($topSellerProducts && count($topSellerProducts) > 0) {
            $data['ProductCarousel'] = [
                "title"=> "Top Sellers",
                "items" => $topSellerProducts->toArray()
            ];
          }

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
        if ($url = $request->get('url')) {
            if ($rule = $this->recursiveFindRewriteRule($url)) {
                return [
                    'status'=>200, 
                    'data'=>$rule
                ];
            }
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