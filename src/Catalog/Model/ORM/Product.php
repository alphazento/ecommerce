<?php

namespace Zento\Catalog\Model\ORM;

use Zento\Contracts\Interfaces\Catalog\IProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class Product extends \Illuminate\Database\Eloquent\Model implements IProduct
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;

    const MODEL_TYPE = "simple";

    protected static $typeMapping = [
        'simple' => '\Zento\Catalog\Model\ORM\Product',
        'grouped' => '\Zento\Catalog\Model\ORM\Product',
        'bundle' => '\Zento\Catalog\Model\ORM\Product',
        'downloadable' => '\Zento\Catalog\Model\ORM\Product',
    ];

    public $_richData_ = [
        'prices',
        'special_price'
    ];

    protected $fillable = [
        'name',
        'attribute_set_id',
        'sku',
        'model_type',
        'active'
    ];

    public static function registerType($model_type, $class) {
        self::$typeMapping[$model_type] = $class;
    }

    public static function getProductTypes() {
        return self::$typeMapping;
    }

    public function getTableFields() {
        return $this->fillable;
    }
    
    public function shippable() {
        return true;
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
        $model = self::newInstanceBaseTypeId($attributes, $this);
        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public static function newInstanceBaseTypeId($attributes = [], $pthis = null) {
        $model_type = false;
        if (is_array($attributes)) {
            if (isset($attributes['model_type'])) {
                $model_type = $attributes['model_type'];
            }
        } elseif (is_object($attributes) && property_exists($attributes, 'model_type')) {
            $model_type = $attributes->model_type;
        }
        if ($model_type) {
            if (isset(self::$typeMapping[$model_type])) {
                $class = self::$typeMapping[$model_type];
                return with(new static)->newInstance([], true);
            }
        } else {
            if ($pthis) {
                return $pthis->newInstance([], true);
            } else {
                return with(new static)->newInstance([], true);
            }
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

    public function getPriceAttribute() {
        return $this->prices->price ?? 0;
    }

    public function getPrice() {
        return $this->prices->price ?? 0;
    }

    public static function assignExtraRelation($products) {
        $reduced = array_filter($products, function($product) {
            return $product->model_type === static::MODEL_TYPE;
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
