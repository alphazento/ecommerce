<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Illuminate\Support\Collection;

class Product extends \Zento\Catalog\Model\ORM\Product
{
    /**
     * all configurable products
     */
    public function configurables() {
        return $this->hasManyThrough(Product::class, ConfigurableProduct::class, 'parent_id', 'id', 'id', 'product_id');
    }

    public static function getPreloadRelations() {
        return array_merge(
            \Zento\Catalog\Model\ORM\Product::getPreloadRelations(),
            [
                'configurables'
            ]);
        return $relations;
    }
}