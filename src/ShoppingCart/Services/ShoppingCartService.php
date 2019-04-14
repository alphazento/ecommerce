<?php

namespace Zento\ShoppingCart\Services;

use DB;
use Store;
use Auth;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;

use Zento\ShoppingCart\Event\ShoppingCartModified;
use Zento\ShoppingCart\Event\PreAddProduct;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartService
{
    protected $cartCache = [];
    
    public function getMyCart($forceCreateForMine = false) {
        if ($myCart = $this->getCartByUserId(Auth::user()->id)) {
            return $myCart;
        } elseif ($forceCreateForMine) {
            return $this->createCart();
        }
    }

    public function getCartByUserId($userId) {
        return ShoppingCart::with(['billing_address', 'shipping_address', 'items', 'items.product'])
            ->where('customer_id', '=', $userId)
            ->where('status', '=', 0)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    public function createCart() {
        $user = Auth::user();
        $cart = new ShoppingCart([
            'guid' => guidv4(),
            'email' => $user->is_guest ? $user->guest_email : $user->getEmail(),
            'customer_id' => $user->getId(),
            "currency" => 'AUD',
            'client_ip' => '',
        ]);
        $cart->save();  
        $this->cartCache[$cart->guid] = $cart;
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

    public function cartBuilder() {
        return ShoppingCart::getQuery();
    }

    public function deleteCart($guid) {
        if ($cart = ShoppingCart::where('guid', $guid)->first()) {
            foreach($cart->items as $item) {
                if ($item) {
                    $item->delete();
                }
            }
            return $cart->delete();
        }
        return false;
    }

    public function setBillingAddress(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, 
        \Zento\Contracts\Address $address, 
        $ship_to_billingaddesss = false) {
        // zento_assert($cart);
        // zento_assert($address);

        if ($cart->billing_address_id) {
            // $cart->billing_address->
        } else {
            $address->save();
            $cart->billing_address_id = $address->id;
        }
        $cart->ship_to_billingaddesss = $ship_to_billingaddesss;
        if ($ship_to_billingaddesss) {
            $cart->shipping_address_id = $cart->billing_address_id;
        }
        $cart->update();
        return true;
    }

    public function setShippingAddress(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, \Zento\Contracts\Address $address) {
        // zento_assert($cart);
        // zento_assert($address);
        $address->save();
        
        $cart->shipping_address_id = $address->id;
        $cart->ship_to_billingaddesss = $cart->billing_address_id == $cart->shipping_address_id;
        $cart->update();
        return true;
    }

    public function setShippingInfo(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, 
        \Zento\Contracts\Address $billing_address,
        bool $ship_to_billingaddesss,
        \Zento\Contracts\Address $shipping_address,
        string $shipping_carrier_code,
        string $shipping_method_code) {
        // zento_assert($cart);
        zento_assert($billing_address);

        if (!$this->setBillingAddress($cart, $billing_address, $ship_to_billingaddesss)) {
            return false;
        }
        if (!$ship_to_billingaddesss && !$this->setShippingAddress($cart, $shipping_address)) {
            return false;
        }
        $cart->shipping_carrier_code = $shipping_carrier_code;
        $cart->shipping_method_code = $shipping_method_code;
        $cart->update();
        return true;
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
    protected function findExistItemByProductOption(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $product_id, array $options = []) {
        $optionStr = json_encode($options);
        foreach($cart->items ?? [] as $item) {
            if ($item->product_id == $product_id) {
                if ((empty($item->options)) || $item->options == '{}' && count($options) ==0 ){
                    return $item;
                }
                if ($item->options == $optionStr) {
                    return $item;
                }
            }
        }
        return null;
    }

    public function addProductById(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $product_id, $quantity, $url, array $options =[]) {
        // zento_assert($cart);
        if ($item = $this->findExistItemByProductOption($cart, $product_id, $options)) {
            $item->quantity += $quantity;
            $item->row_price = $item->unit_price * $item->quantity;
            $item->save();
            if ($this->shoppingCartModified($cart)->isSuccess()) {
                return $item;
            }
        } elseif ($product = \Zento\Catalog\Model\ORM\Product::find($product_id)) {
            return $this->addProductAsNewItem($cart, $product, $quantity, $url, $options);
        }
    }

    public function addProduct(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, \Zento\Contracts\Catalog\Model\Product $product, $quantity, $url, array $options =[]) {
        // zento_assert($cart);
        // zento_assert($product);
        if ($item = $this->findExistItemByProductOption($cart, $product->id, $options)) {
            $newQuantity = $item->quantity + $quantity;
            $ret = (new PreAddProduct($product, $options, $newQuantity))->fireUntil();
            if (!$ret->isSuccess()) {
                return false;
            }
            $item->quantity = $newQuantity;
            $item->row_price = $item->unit_price * $item->quantity;
            $item->save();
            if ($this->shoppingCartModified($cart)->isSuccess()) {
                return $item;
            }
        } else {
            return $this->addProductAsNewItem($cart, $product, $quantity, $url, $options);
        }
    }

    protected function addProductAsNewItem(
        \Zento\Contracts\Catalog\Model\ShoppingCart $cart, 
        \Zento\Contracts\Catalog\Model\Product $product, 
        $quantity, $url, array $options =[]) {
        // zento_assert($cart);
        // zento_assert($product);
        $ret = (new PreAddProduct($product, $options, $quantity))->fireUntil();
        if (!$ret->isSuccess()) {
            return false;
        }

        $realProduct = $product->getRealProductForShoppingCart($options);
        $price = $realProduct->getPrice();
        $item = new \Zento\ShoppingCart\Model\ORM\ShoppingCartItem([
            'cart_id' => $cart->id,
            'name' => $realProduct->name,
            'product_id' => $product->id,
            'sku' => $product->sku,
            'product_hash' => md5(json_encode($product->toArray())),
            'price' => (string)$price,
            'custom_price' => (string)$price,
            'quantity' => $quantity,
            'shippable' => $product->shippable(),
            'taxable' => true,
            'unit_price' => $price,
            'row_price' => $price * $quantity,
            'options' => json_encode($options)
        ]);
        $item->save();
        if ($this->shoppingCartModified($cart)->isSuccess()) {
            return $item;
        }
    }

    public function addItem(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, 
        \Zento\Contracts\Catalog\Model\ShoppingCartItem $cartItem, 
        $trigger_event = true) {
        // zento_assert($cart);
        // zento_assert($item);
        if ($item = $this->findExistItemByProductOption($cart, $cartItem->product_id, $options)) {
            $newQuantity = $item->quantity + $cartItem->quantity;
            $ret = (new PreAddProduct($product, $options, $newQuantity))->fireUntil();
            if ($ret) {
                return $ret;
            }
            $item->quantity = $newQuantity;
            $item->row_price = $item->unit_price * $item->quantity;
            $item->save();
            $trigger_event && ($this->shoppingCartModified($cart)->isSuccess());
            return $item;
        } else {
            $cartItem->cart_id = $cart->id;
            $cartItem->save();
            $trigger_event && ($this->shoppingCartModified($cart)->isSuccess());
            return $cartItem;
        }
    }

    public function updateItem(\Zento\Contracts\Catalog\Model\ShoppingCartItem $item, $options) {
        
    }

    public function updateItemQuantity(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $item_id, $quantity) {
        if ($quantity <=0) {
            return $this->deleteItem($cart, $item_id);
        }

        // zento_assert($cart);
        foreach($cart->items as $item) {
            if ($item->id == $item_id) {
                if ($item->quantity != $quantity) {
                    // pre check event.
                    // $ret = (new PreAddProduct($product, $options, $quantity))->fireUntil();
                    // if ($ret) {
                    //     return false;
                    // }
                    $item->quantity = $quantity;
                    $item->row_price = $item->unit_price * $item->quantity;
                    $item->update();
                    $this->shoppingCartModified($cart);
                }
                return true;
            }
        }
        return false;
    }

    public function deleteItem(\Zento\Contracts\Catalog\Model\ShoppingCart $cart, $item_id) {
        // zento_assert($cart);
        foreach($cart->items as $item) {
            if ($item->id == $item_id) {
                $item->delete();
                $this->shoppingCartModified($cart);
                return true;
            }
        }
        return false;
    }

    public function shoppingCartModified(\Zento\Contracts\Catalog\Model\ShoppingCart $cart) {
        // zento_assert($cart);
        $cart->load('items');
        return (new ShoppingCartModified($cart))->fireUntil();
    }
}