<?php

namespace Zento\ElsCatalog\Processor;

use ProductService;
use Zento\Catalog\Model\ORM\Product as OrmProduct;
use Zento\ElsCatalog\Model\ElsIndex\Product;

class ProductSync {
    protected $searchables;
    public function __construct() {
        $this->searchables =  ProductService::getProductSearchables();
    }
    public function sync() {
        $collection = OrmProduct::with(['categories'])->chunk(100, function($collection) {
            foreach($collection as $item) {
                $this->sync_item($item);
            }
        });
    }

    protected function sync_item($ormProduct) {
        $product = Product::where('id', '=', $ormProduct->id)->first();
        if (!$product) {
            $product = new Product();
        }
        $data = $ormProduct->toArray();
        $data['category'] = $ormProduct->categories->pluck('id');
        unset($data['categories']);
        $this->mergeSearchablesToParent($data);
        $product->forceFill($data);
        $product->save();
    }

    protected function mergeSearchablesToParent(array &$product) {
        if ($product['model_type'] === 'configurable') {
            foreach($this->searchables ?? [] as $attribute) {
                $values = $product[$attribute] ?? [];
                $values = is_array($values) ? $values : [$values];
                foreach($product['configurables'] ?? [] as $subProduct) {
                    if ($tmp = $subProduct[$attribute] ?? false) {
                        $values = array_merge($values, is_array($tmp) ? $tmp : [$tmp]);
                    }
                }
                $product[$attribute] = array_unique($values);
            }
        }
    }
}