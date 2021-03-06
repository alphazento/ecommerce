<?php

namespace Zento\ShoppingCart\Services;

use Auth;
use Illuminate\Support\Str;
use Request;
use Zento\Catalog\Model\ORM\Product as BaseProduct;
use Zento\Contracts\Interfaces\Catalog\IShoppingCart;
use Zento\Contracts\Interfaces\Catalog\IShoppingCartItem;
use Zento\ShoppingCart\Event\PreAddProduct;
use Zento\ShoppingCart\Event\ShoppingCartUpdated;
use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Zento\ShoppingCart\Model\ORM\ShoppingCartItem;

class ShoppingCartService
{
    protected $cartCache = [];

    public function getMyCart($forceCreateForMine = false)
    {
        $user = Request::user();
        if ($myCart = $this->getCartByUser($user)) {
            return $myCart;
        } elseif ($forceCreateForMine) {
            return $this->createCart();
        }
    }

    public function getCartByUser($user)
    {
        $query = ShoppingCart::with(['billing_address', 'shipping_address', 'items', 'items.product'])
            ->where('status', '=', 0)
            ->orderBy('updated_at', 'desc');
        if ($user->is_guest) {
            $query->where('uuid', '=', $user->id);
        } else {
            $query->where('customer_id', '=', $user->id);
        }
        return $query->first();
    }

    public function createCart()
    {
        $user = Auth::user();
        $cart = new ShoppingCart([
            'uuid' => $user->is_guest ? $user->id : Str::uuid(),
            'email' => $user->email,
            'customer_id' => $user->is_guest ? 0 : $user->id,
            "currency" => 'AUD',
            'client_ip' => '',
        ]);
        $cart->save();
        $this->cartCache[$cart->id] = $cart;
        return $cart;
    }

    public function cart($id)
    {
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

    public function cartBuilder()
    {
        return ShoppingCart::getQuery();
    }

    public function deleteCart($id)
    {
        if ($cart = ShoppingCart::find($id)) {
            foreach ($cart->items as $item) {
                if ($item) {
                    $item->delete();
                }
            }
            return $cart->delete();
        }
        return false;
    }

    public function setBillingAddress(IShoppingCart $cart,
        \Zento\Contracts\Interfaces\IAddress $address,
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

    public function setShippingAddress(IShoppingCart $cart, \Zento\Contracts\Interfaces\IAddress $address)
    {
        // zento_assert($cart);
        // zento_assert($address);
        $address->save();

        $cart->shipping_address_id = $address->id;
        $cart->ship_to_billingaddesss = $cart->billing_address_id == $cart->shipping_address_id;
        $cart->update();
        return true;
    }

    public function setShippingInfo(IShoppingCart $cart,
        \Zento\Contracts\Interfaces\IAddress $billing_address,
        bool $ship_to_billingaddesss,
        \Zento\Contracts\Interfaces\IAddress $shipping_address,
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

    public function addCoupon($cart, $coupon)
    {
        if ($cart->coupon_code == $coupon) {
            return true;
        }

        $cart->coupon_code = $coupon;
        $this->ShoppingCartUpdated($cart);
        return $cart->coupon_code == $coupon;
    }

    /**
     * try to find if the product_id and options combination exsits in current cart
     *
     * @param [type] $items
     * @param [type] $product
     * @param array $options
     * @return void
     */
    protected function findExistItemByProductOption(IShoppingCart $cart, $product_id, array $options = [])
    {
        $optionStr = json_encode($options);
        foreach ($cart->items ?? [] as $item) {
            if ($item->product_id == $product_id) {
                if ((empty($item->options)) || $item->options == '{}' && count($options) == 0) {
                    return $item;
                }
                if ($item->options == $optionStr) {
                    return $item;
                }
            }
        }
        return null;
    }

    public function addProduct(IShoppingCart $cart, $product_id, $quantity, array $options = [])
    {
        if ($product = BaseProduct::thinMode()->find($product_id)) {
            $cartItem = $product->findExistCartItem($cart, $options);
            if (!$cartItem) {
                $itemData = $product->prepareToCartItem($options);
                $itemData['cart_id'] = $cart->id;
                $cartItem = new ShoppingCartItem($itemData);
            }
            $cartItem->quantity += $quantity;
            $cartItem->row_price = $cartItem->custom_price * $cartItem->quantity;
            $cartItem->save();

            if ($this->ShoppingCartUpdated($cart)->isSuccess()) {
                return $cartItem;
            }
        }
    }

    public function addItem(IShoppingCart $cart, IShoppingCartItem $cartItem,
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
            $trigger_event && ($this->ShoppingCartUpdated($cart)->isSuccess());
            return $item;
        } else {
            $cartItem->cart_id = $cart->id;
            $cartItem->save();
            $trigger_event && ($this->ShoppingCartUpdated($cart)->isSuccess());
            return $cartItem;
        }
    }

    public function updateItem(IShoppingCartItem $item, $options)
    {

    }

    public function updateItemQuantity(IShoppingCart $cart, $item_id, $quantity)
    {
        if ($quantity <= 0) {
            return $this->deleteItem($cart, $item_id);
        }

        // zento_assert($cart);
        foreach ($cart->items as $item) {
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
                    $this->ShoppingCartUpdated($cart);
                }
                return true;
            }
        }
        return false;
    }

    public function deleteItem(IShoppingCart $cart, $item_id)
    {
        // zento_assert($cart);
        foreach ($cart->items as $item) {
            if ($item->id == $item_id) {
                $item->delete();
                $this->ShoppingCartUpdated($cart);
                return true;
            }
        }
        return false;
    }

    public function ShoppingCartUpdated(IShoppingCart $cart)
    {
        // zento_assert($cart);
        $cart->load('items.product');
        return (new ShoppingCartUpdated($cart))->fireUntil();
    }

    public function updateCustomerDetails(IShoppingCart $cart, $customer)
    {
        $cart->email = $customer->email;
        $cart->customer_id = $customer->is_guest ? 0 : $customer->id;
        $cart->save();
        return $cart;
    }
}
