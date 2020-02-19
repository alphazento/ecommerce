<?php

namespace Zento\Catalog\Model\ORM;

use Zento\Contracts\Interfaces\Catalog\IProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class Product extends \Illuminate\Database\Eloquent\Model implements IProduct
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    const TYPE_ID = "simple";

    protected static $typeMapping = [
        'simple' => '\Zento\Catalog\Model\ORM\Product',
        'grouped' => '\Zento\Catalog\Model\ORM\Product',
        'bundle' => '\Zento\Catalog\Model\ORM\Product',
        'downloadable' => '\Zento\Catalog\Model\ORM\Product',
    ];

    public $_richData_ = [
        'desc',
        'prices',
        'special_price'
    ];

    public static function registerType($type_id, $class) {
        self::$typeMapping[$type_id] = $class;
    }

    public static function getProductTypes() {
        return self::$typeMapping;
    }
    
    public function shippable() {
        return true;
    }
   
    public function desc() {
        return $this->hasOne(ProductDescription::class, 'product_id');
    }

    public function prices() {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function special_price() {
        return $this->hasOne(ProductSpecialPrice::class, 'product_id');
    }

    /**
     * @override from \Illuminate\Database\Eloquent\Model
     *
     * @param  array  $attributes
     * @param  string|null  $connection
     * @return static
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = $this->newInstanceBaseTypeId($attributes);

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    protected function newInstanceBaseTypeId($attributes = []) {
        $type_id = false;
        if (is_array($attributes)) {
            if (isset($attributes['type_id'])) {
                $type_id = $attributes['type_id'];
            }
        } elseif (is_object($attributes) && property_exists($attributes, 'type_id')) {
            $type_id = $attributes->type_id;
        }
        if ($type_id) {
            if (isset(self::$typeMapping[$type_id])) {
                $class = self::$typeMapping[$type_id];
                return new $class([], true);
            }
        } else {
            return $this->newInstance([], true);
        }
    }

    /**
     * base on type id, some inheritence class may not load some relationshop
     *
     * @return void
     */
    protected function lazyLoadRelation() {
        //do nothing for simple product
    }

    /**
     * all its categories
     */
    public function categories() {
        return $this->hasManyThrough(Category::class, CategoryProduct::class, 'product_id', 'id', 'id', 'category_id')
            ->orderBy('level');
    }

    public function getNameAttribute() {
        return $this->desc->name ?? '';
    }

    public function getDescriptionAttribute() {
        return $this->desc->description ?? '';
    }

    public function getPriceAttribute() {
        return $this->prices->price ?? 0;
    }

    public function getPrice() {
        return $this->prices->price ?? 0;
    }

    public static function assignExtraRelation($products) {
        $reduced = array_filter($products, function($product) {
            return $product->type_id === static::TYPE_ID;
        });
        $ids = array_map(function($product) {
            return $product->id;
        }, $reduced);
        return [$reduced, $ids];
    }

    /**
     * check if shopping cart has same item exists
     *
     * @param IShoppingCart $cart
     * @param array $options
     * @return boolean
     */
    public function findExistCartItem(IShoppingCart $cart, array &$options) {
        foreach($cart->items ?? [] as $item) {
            if ($item->product_id === $this->id) {
                return $item;
            }
        }
        return false;
    }

    /**
     * prepare to item
     *
     * @param array $options
     * @return void
     */
    public function prepareToCartItem(array &$options) {
        $price = (string)$this->prices->price;
        return [
            'price' => $price,
            'name' => $this->name,
            'product_id' => $this->id,
            'sku' => $this->sku,
            'custom_price' => $price,
            'quantity' => 0,
            'shippable' => $this->shippable(),
            'taxable' => true,
            'unit_price' => $price,
            'row_price' => 0,
            'options' => json_encode($options)
        ];
    }

    public function actualProductsInCart(array $options, $toArray = false) {
        return null;
    }
}
