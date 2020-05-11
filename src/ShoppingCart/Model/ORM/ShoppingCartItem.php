<?php

namespace Zento\ShoppingCart\Model\ORM;

use Zento\Catalog\Model\ORM\Product;
use Zento\Contracts\Interfaces\Catalog\IShoppingCartItem;

class ShoppingCartItem extends \Illuminate\Database\Eloquent\Model implements IShoppingCartItem
{
    protected $fillable = self::PROPERTIES;
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getOptionsAttribute()
    {
        $text = $this->attributes['options'] ?? '{}';
        return json_decode($text, true);
    }

    public function toArray()
    {
        $data = parent::toArray();
        if ($this->product) {
            $data['actuals'] = $this->product->actualProductsInCart($this->options, true);
        }
        return $data;
    }
}
