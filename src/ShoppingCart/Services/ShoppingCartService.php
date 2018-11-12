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
            $cart_guid = session()->get('shopping_cart', 0);
            if ($cart_guid) {
                $this->myCart = $this->cart($cart_guid);
            }
        }
        return $this->myCart;
    }

    public function newCart() {
        $cart = new ShoppingCart([
            'guid' => guidv4(),
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
        $this->cartCache[$cart->guid] = $cart;
        $this->myCart = $cart;
        session()->put('shopping_cart', $cart->guid);
        return $cart;
    }

    public function cart($guid) {
        if (!isset($this->cartCache[$guid])) {
            if ($cart = ShoppingCart::where('guid', $guid)->first()) {
                $this->cartCache[$guid] = $cart;
                return $cart;
            } else {
                return null;
            }
        }
        return $this->cartCache[$guid];
    }

    public function carts($filters) {
        // return ShoppingCart::whereIn('id', $);
    }

    public function deleteCart($guid) {
        if ($cart = ShoppingCart::where('guid', $guid)->first()) {
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

    public function addProductById(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $product_id, $quantity, array $options =[]) {
        zento_assert($cart);
        if ($item = $this->findExistItem($cart, $product_id, $options)) {
            $item->quantity += $quantity;
            $item->total_price = $item->unit_price * $item->quantity;
            $item->save();
            return $item;
        } elseif ($product = \Zento\Catalog\Model\ORM\Product::find($product_id)) {
            return $this->addNewItem($cart, $product, $quantity, $options);
        }
    }

    protected function addNewItem(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, \Zento\Contracts\Catalog\Model\Product $product, $quantity, array $options =[]) {
        zento_assert($cart);
        zento_assert($product);
        $item = new \Zento\ShoppingCart\Model\ORM\ShoppingCartItem([
            'cart_id' => $cart->id,
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

    public function addProduct(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, \Zento\Contracts\Catalog\Model\Product $product, $quantity, array $options =[]) {
        zento_assert($cart);
        zento_assert($product);
        if ($item = $this->findExistItem($cart, $product->id, $options)) {
            $item->quantity += $quantity;
            $item->total_price = $item->unit_price * $item->quantity;
            $item->save();
            return $item;
        } else {
            return $this->addNewItem($product, $quantity, $options);
        }
    }

    public function addItem(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, \Zento\Contracts\Catalog\Model\ShoppingCartItem $cartItem) {
        zento_assert($cart);
        zento_assert($item);
        if ($item = $this->findExistItem($cart, $cartItem->product_id, $options)) {
            $item->quantity += $quantity;
            $item->total_price = $item->unit_price * $item->quantity;
            $item->save();
            return $item;
        } else {
            $cartItem->cart_id = $cart->id;
            $cartItem->cart_id = $cart->id;
            $cartItem->save();
            $cart->refresh();
            return $cartItem;
        }
    }

    public function updateItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $item) {
        
    }

    public function updateItemQuantity($cart_id, $id, $quantity) {
        
    }

    public function deleteItem($cart_id, $item_id) {

    }
}