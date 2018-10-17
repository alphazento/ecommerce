<?php

namespace Zento\Catalog\Services;

use DB;
use Store;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Catalog\Model\ORM\Product;

class ProductService implements \Zento\Contracts\Catalog\Service\ProductServiceInterface
{
    public function getProductById($id) {
        return Product::find($id);
    }

    public function getProductBySku($sku) {
        return Product::where('sku', $sku)->first();
    }

    public function getProductsByIds(array $ids) {
        if (empty($ids)) {
            return null;
        }
        return Product::whereIn('id', $ids)->get();
    }

    public function getProductsBySkus(array $skus) {
        if (empty($skus)) {
            return null;
        }
        return Product::whereIn('sku', $skus)->get();
    }

    public function getLatestProducts($limit) {

    }

    public function getPopularProducts($limit) {

    }

    public function getBestSellerProducts($limit) {

    }

    public function __call($method, $args) {
        return Product::{$method}(...$args);
    }
}