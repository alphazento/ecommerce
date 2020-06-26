<?php

namespace Zento\Catalog\Model\ORM\Concerns;

use Zento\Contracts\Interfaces\Catalog\IShoppingCart;

trait TraitCartProduct
{
    /**
     * prepare to item
     *
     * @param array $options
     * @return void
     */
    public function prepareToCartItem(array &$options)
    {
        $price = (string) $this->final_price;
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

    public function actualProductsInCart(array $options, $toArray = false)
    {
        return null;
    }
}
