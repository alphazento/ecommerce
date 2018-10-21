<?php

namespace Zento\ShoppingCart\Services;

use DB;
use Store;
use Auth;
use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartService
{
    protected $myCart;
    protected $cartCache = [];
    public function myCart() {
        if (!$this->myCart) {
            $cart_id = session()->get('shopping_cart', 0);
            if ($cart_id) {
                $this->myCart = $this->cart($cart_id);
            }
        }
        return $this->myCart;
    }

    public function newCart() {
        $cart = new ShoppingCart([
            'email' => Auth::guest() ? '' : Auth::user()->getEmail(),
            'customer_id' => Auth::guest() ? 0 : Auth::user()->getId(),
            'store_id' => 0,
            'mode' => '',   //test, stag, live
            'status' => 1,
            'applied_rule_ids' => '',
            'ship_to_billingaddesss' => false, //boolean,
            'billing_address_id' => 0,
            'shipping_address_id' => 0,
            'invoice_number' => 0,
            'payment_method' => 0,
            "currency" => '',
            "total_weight" => 0,
            "total" => 0,
            'client_ip' => '',
            'grand_total' => 0,
            'subtotal' => 0,
            'subtotal_with_discount' => 0
        ]);
        $cart->save();
        $this->cartCache[$cart->id] = $cart;
        $this->myCart = $cart;
        session()->put('shopping_cart', $cart->id);
        return $cart;
    }

    public function cart($id) {
        if (!isset($this->cartCache[$id])) {
            if ($cart = ShoppingCart::find($id)) {
                $this->cartCache[$id] = $cart;
                return $cart;
            } else {
                return null;
            }
        }
        return $this->cartCache[$id];
    }

    public function carts($filters) {
        // return ShoppingCart::whereIn('id', $);
    }

    public function deleteCart($id) {
        if ($cart = ShoppingCart::find($id)) {
            return $cart->delete();
        }
        return false;
    }

    public function setBillingAddress(\Zento\Contracts\Catalog\Model\ShoppingCartAddress $address) {

    }

    public function setShoppingAddress(\Zento\Contracts\Catalog\Model\ShoppingCartAddress $address) {

    }

    public function addCoupon($coupon) {

    }

    /**
     * try to find if the product_id and options combination exsits in current cart
     *
     * @param [type] $items
     * @param [type] $product
     * @param array $options
     * @return void
     */
    protected function findExistItem(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $product_id, array $options = []) {
        foreach($cart->items ?? [] as $item) {
            if ($item->product_id == $product_id) {
                if ($item->options == $options) {
                    return $item;
                } else {
                    if ((empty($item->options) || $item->options->isEmpty()) && empty($options)) {
                        return $item;
                    }
                }
            }
        }
        return null;
    }

    public function addProductById($product_id, $quantity, array $options =[]) {
        if ($mycart = $this->myCart()) {
            if ($item = $this->findExistItem($mycart, $product_id, $options)) {
                $item->quantity += $quantity;
                $item->total_price = $item->unit_price * $item->quantity;
                $item->save();
                return $item;
            } elseif ($product = \Zento\Catalog\Model\ORM\Product::find($product_id)) {
                return $this->addNewItem($product, $quantity, $options);
            }
        }
        return false;
    }

    protected function addNewItem(\Zento\Contracts\Catalog\Model\Product $product, $quantity, array $options =[]) {
        zento_assert($product);
        $item = new \Zento\ShoppingCart\Model\ORM\ShoppingCartItem([
            'cart_id' => $this->myCart->id,
            'name' => $product->name,
            'product_id' => $product->id,
            'sku' => $product->sku,
            'price' => (string)$product->price,
            'custom_price' => (string)$product->price,
            'description' => (string)$product->description,
            'url' => (string)$product->url_path,
            'image' => (string)$product->image,
            'quantity' => $quantity,
            'min_quantity' => 1,
            'max_quantity' => $quantity * 2,
            'shippable' => true,
            'taxable' => true,
            'duplicatable' => true,
            'unit_price' => $product->price,
            'total_price' => $product->price * $quantity,
            'tax_amount' => 0
        ]);
        $item->save();
        return $item;
    }

    public function addProduct(\Zento\Contracts\Catalog\Model\Product $product, $quantity, array $options =[]) {
        zento_assert($product);
        if ($mycart = $this->myCart()) {
            if ($item = $this->findExistItem($mycart, $product->id, $options)) {
                $item->quantity += $quantity;
                $item->total_price = $item->unit_price * $item->quantity;
                $item->save();
                return $item;
            } else {
                return $this->addNewItem($product, $quantity, $options);
            }
        }
        return false;
    }

    public function addItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $cartItem) {
        zento_assert($item);
        if ($mycart = $this->myCart()) {
            if ($item = $this->findExistItem($mycart, $cartItem->product_id, $options)) {
                $item->quantity += $quantity;
                $item->total_price = $item->unit_price * $item->quantity;
                $item->save();
                return $item;
            } else {
                $cartItem->cart_id = $mycart->id;
                $cartItem->cart_id = $mycart->id;
                $cartItem->save();
                $mycart->refresh();
                return $cartItem;
            }
        }
        return false;
    }

    public function updateItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $item) {
        
    }

    public function updateItemQuantity($cart_id, $id, $quantity) {
        
    }

    public function deleteItem($cart_id, $item_id) {

    }
}