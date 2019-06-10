<?php

namespace Zento\ShoppingCart\Model\ORM;

use DB;
use Illuminate\Support\Collection;
use Zento\Catalog\Model\ORM\Product;
use Zento\Contracts\Interfaces\Catalog\IShoppingCartItem;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model 
    implements IShoppingCartItem
{
    protected $fillable = self::PROPERTIES;
    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}