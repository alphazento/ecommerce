<?php

namespace Zento\Catalog\Model\ORM;

use Auth;
use Illuminate\Database\Eloquent\Concerns\SelfMorphModel;
// use Zento\Kernel\Booster\Database\Eloquent\TraitMorphModel;
use ShareBucket;
use Zento\Contracts\Interfaces\Catalog\IProduct;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

class Product extends \Illuminate\Database\Eloquent\Model implements IProduct
{
    use \Zento\Kernel\Booster\Database\Eloquent\DA\DynamicAttributeAbility;
    use SelfMorphModel;

    const MODEL_TYPE = "simple";

    protected $fillable = [
        'name',
        'attribute_set_id',
        'sku',
        'morph_type',
        'active',
    ];

    public function getRichDataDefines()
    {
        if (ShareBucket::get(\Zento\Kernel\Consts::ZENTO_PORTAL) === 'admin') {
            return [
                'prices',
                'special_prices',
            ];
        } else {
            return ['price'];
        }
    }

    public function getTableFields()
    {
        return $this->fillable;
    }

    public function shippable()
    {
        return true;
    }

    /**
     * if frontend it will only get this price
     */
    public function price()
    {
        $groupId = Auth::user()->group_id ?? 0;
        return $this->hasOne(ProductPrice::class, 'product_id')
            ->whereIn('customer_group_id', [$groupId, 0])
            ->orderBy('customer_group_id', 'desc');
    }

    /**
     * admin portal support customer groups
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }

    public function special_prices()
    {
        return $this->hasMany(ProductSpecialPrice::class, 'product_id');
    }

    /**
     * base on type id, some inheritence class may not load some relationshop
     *
     * @return void
     */
    protected function lazyLoadRelation()
    {
        //do nothing for simple product
    }

    /**
     * all its categories
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, CategoryProduct::class, 'product_id', 'id', 'id', 'category_id')
            ->orderBy('level');
    }

    public function getFinalPriceAttribute()
    {
        return $this->price->final_price ?? 0;
    }

    public static function assignExtraRelation($products)
    {
        $reduced = array_filter($products, function ($product) {
            return $product->morph_type === static::MODEL_TYPE;
        });
        $ids = array_map(function ($product) {
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
    public function findExistCartItem(IShoppingCart $cart, array &$options)
    {
        foreach ($cart->items ?? [] as $item) {
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
    public function prepareToCartItem(array &$options)
    {
        $price = (string) $this->price->final_price;
        return [
            'name' => $this->name,
            'product_id' => $this->id,
            'sku' => $this->sku,
            'custom_price' => $price,
            'quantity' => 0,
            'shippable' => $this->shippable(),
            'taxable' => true,
            'unit_price' => $price,
            'row_price' => 0,
            'options' => json_encode($options),
        ];
    }

    public function actualProductsInCart(array $options, $toArray = false)
    {
        return null;
    }
}
