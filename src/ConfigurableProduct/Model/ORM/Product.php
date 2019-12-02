<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Zento\Catalog\Model\ORM\Product as SimpleProduct;
use Zento\Catalog\Providers\Facades\ProductService;
use Illuminate\Support\Collection;

class Product extends SimpleProduct
{
    /**
     * all configurable products
     */
    public function configurables() {
        return $this->hasManyThrough(Product::class, ConfigurableProduct::class, 'parent_id', 'id', 'id', 'product_id');
    }

    protected function lazyLoadRelation() {
        $this->load('configurables');
    }

    public function getRealProductForShoppingCart($options = null) {
        if (is_string($options)) {
            $options = json_decode($options);
        }
        
        if ($options && $options['item_id']) {
            if ($product = $this->findProductFromConfigurablesById($options['item_id'])) {
                return $product;
            }
        }
        return $this;
    }

    protected function findProductFromConfigurablesById($id) {
        if (isset($this->relations['configurables'])) {
            foreach($this->configurables as $product) {
                if ($product->id == $id) {
                    return $product;
                }
            }
        }
        return ProductService::getProductById($id);
    }

    public static function assignExtraRelation($products) {
        $reduced = array_filter($products, function($product) {
            return $product->type_id === 'configurable';
        });
        $ids = array_map(function($product) {
            return $product->id;
        }, $reduced);

        if (count($ids) > 0) {
            // foreach($collection as $)
            $name = 'configurables';
            $relation = (new static)->configurables();
            $relation->orWhereIn('parent_id', $ids);
            $relation->match(
                $relation->initRelation($reduced, $name),
                $relation->getEager(), $name
            );
        }
    }
}