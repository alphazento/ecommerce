<?php

namespace Zento\ElsCatalog\Model\ORM;

class Product extends \Zento\Catalog\Model\ORM\Product
{
   /**
     * all its categories
     */
    public function categories() {
        return $this->hasManyThrough(Category::class, CategoryProduct::class, 'product_id', 'id', 'id', 'category_id');
    }
}