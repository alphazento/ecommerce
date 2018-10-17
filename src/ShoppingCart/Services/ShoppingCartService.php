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
        $this->cartCache[$cart->getId()] = $cart;
        $this->myCart = $cart;
        session()->put('shopping_cart', $cart->getId());
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

    public function addProductById($product_id, $quantity, $options) {
        if ($product = ProductService::getProductById($product_id)) {
            
        }
    }

    public function addProduct(\Zento\Contracts\Catalog\Model\Product $product, $quantity, $options) {

    }

    public function addItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $item) {

    }

    public function updateItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $item) {
        
    }

    public function updateItemQuantity($cart_id, $id, $quantity) {
        
    }

    public function deleteItem($cart_id, $id) {

    }
}