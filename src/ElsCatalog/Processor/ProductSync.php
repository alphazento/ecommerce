<?php

namespace Zento\ElsCatalog\Processor;

use Zento\Catalog\Model\ORM\Product as OrmProduct;
use Zento\ElsCatalog\Model\ElsIndex\Product;

class ProductSync {
    public function sync() {
        $collection = OrmProduct::all();
        foreach($collection as $item) {
            $this->sync_item($item);
        }
    }

    protected function sync_item($ormProduct) {
        $product = null;
        try {
            $product = Product::where('id', '=', $ormProduct->id)->first();
        } catch (\Exception $e) {

        }
        if (!$product) {
            $product = new Product();
        }
        $product->forceFill($ormProduct->toArray());
        $product->save();
    }
}