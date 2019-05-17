<?php

namespace Zento\ElsCatalog\Processor;

use Zento\Catalog\Model\ORM\Product as OrmProduct;
use Zento\ElsCatalog\Model\ElsIndex\Product;

class ProductSync {
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
        $data['categories'] = $ormProduct->categories->pluck('id');
        $product->forceFill($data);
        $product->save();
    }
}