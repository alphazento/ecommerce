<?php

namespace Zento\ConfigurableProduct\Model\ORM;

use Zento\Catalog\Model\ORM\Product as SimpleProduct;
use Zento\Catalog\Providers\Facades\ProductService;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Illuminate\Support\Collection;

class Product extends SimpleProduct
{
    const REQUIRE_OPTION_KEY = 'actual_pid';  //actual product id

    /**
     * all configurable products
     */
    public function configurables() {
        return $this->hasManyThrough(Product::class, ConfigurableProduct::class, 'parent_id', 'id', 'id', 'product_id');
    }

    protected function lazyLoadRelation() {
        $this->load('configurables');
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

    /**
     * check if shopping cart has same item exists
     *
     * @param IShoppingCart $cart
     * @param array $options
     * @return boolean
     */
    public function findExistCartItem(IShoppingCart $cart, array &$options) {
        $this->checkOptions($options);

        foreach($cart->items ?? [] as $item) {
            if ($item->product_id != $this->id) {
                continue;
            }

            $actual_pid = $item->options[self::REQUIRE_OPTION_KEY] ?? false;
            if ($actual_pid == $options[self::REQUIRE_OPTION_KEY]) {
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
        $this->checkOptions($options);
        $actual_pid = $options[self::REQUIRE_OPTION_KEY];
        // if ($actualProduct = SimpleProduct::find($actual_pid)) {
        if ($actualProduct = ConfigurableProduct::where('parent_id', $this->id)
                ->where('product_id', $actual_pid)
                ->first()) {
            $itemData = $actualProduct->product->prepareToCartItem($options);
            $itemData['product_id'] = $this->id;
            $itemData['name'] = $this->name;
            return $itemData;
        }
        throw new \Exception(sprintf('configurable product actual product not find.', self::REQUIRE_OPTION_KEY));
    }

    /**
     * get actual products from options
     *
     * @param array $options shopping cart item options
     * @return void
     */
    public function actualProductsInCart(array $options, $toArray = false) {
        if ($actual_pid = $options[self::REQUIRE_OPTION_KEY] ?? false) {
            if ($actual = SimpleProduct::find($actual_pid)) {
                return [
                    ['product' => $toArray ? $actual->toArray() : $actual, 'quantity' => 1]
                ];
            }
        }
        return null;
    }

    protected function checkOptions(array &$options) {
        if (!isset($options[self::REQUIRE_OPTION_KEY])) {
            throw new \Exception(sprintf('configurable product required option %s not exists', self::REQUIRE_OPTION_KEY));
        }
        return $this;
    }

}