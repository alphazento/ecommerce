<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Illuminate\Support\Collection;
use Zento\Catalog\Providers\Facades\ProductService;

class Product extends \Zento\Catalog\Model\ORM\Product
{
    /**
     * all configurable products
     */
    public function configurables() {
        return $this->hasManyThrough(Product::class, ConfigurableProduct::class, 'parent_id', 'id', 'id', 'product_id');
    }

    public $_richData_ = [
        'desc',
        'prices',
        'special_price',
        'configurables'
    ];

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
}