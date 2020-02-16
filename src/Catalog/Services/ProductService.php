<?php

namespace Zento\Catalog\Services;

use DB;
use Store;
use Closure;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Catalog\Model\ORM\Product;
use Zento\Kernel\Booster\Database\Eloquent\DA\ORM\DynamicAttribute;

class ProductService implements \Zento\Contracts\Interfaces\Service\ProductServiceInterface
{
    protected $lazyRelationHandlers = [];

    public function registerLazyRelationHandler(Closure $callback) {
        $this->lazyRelationHandlers[] = $callback;
        return $this;
    }

    public function getProductById($id) {
        return $this->singleProductExtraRelation(Product::find($id));
    }

    public function getProductBySku($sku) {
        return $this->singleProductExtraRelation(Product::where('sku', $sku)->first());

    }

    public function getProductsByIds(array $ids) {
        if (empty($ids)) {
            return null;
        }
        return $this->massProductExtraRelation(Product::whereIn('id', $ids)->get());
    }

    public function getProductsBySkus(array $skus) {
        if (empty($skus)) {
            return null;
        }
        return $this->massProductExtraRelation(Product::whereIn('sku', $skus)->get());
    }

    public function getLatestProducts($limit) {

    }

    public function getPopularProducts($limit) {

    }

    public function getBestSellerProducts($limit) {
        return $this->massProductExtraRelation(Product::offset(0)->take($limit)->get());
    }

    public function __call($method, $args) {
        return Product::{$method}(...$args);
    }

    public function getProductSwatches() {
        $attributes = DynamicAttribute::with(['options'])
            ->where('swatch_type', '>', '0')
            ->where('active', 1)
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

    public function getProductSearchables() {
        return DynamicAttribute::where('is_search_layer', '>', '0')
            ->where('active', 1)
            ->pluck('attribute_name')
            ->toArray();
    }

    protected function singleProductExtraRelation($product) {
        if ($product) {
            $product->assignExtraRelation([$product]);
        }
        return $product;
    }

    protected function massProductExtraRelation($products) {
        if ($products) {
            foreach($this->lazyRelationHandlers as $handler) {
                $handler($products);
            }
        }
        return $products;
    }
}