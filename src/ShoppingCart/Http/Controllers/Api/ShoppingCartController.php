<?php

namespace Zento\ShoppingCart\Http\Controllers\Api;


use Auth;
use Route;
use Response;
use Registry;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;
use Zento\Catalog\Providers\Facades\ProductService;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zento\Kernel\Http\Controllers\ApiBaseController;

class ShoppingCartController extends ApiBaseController
{
    use TraitShoppingCartHelper;

    /**
     * Retrieves current user's shopping cart
     * @group Shopping Cart
     */
    public function getCart() {
        return $this->tapCart(function($cart) {
            return $this->withData($cart);
        });
    }

    /**
     * create a new shopping cart for current user
     * @group Shopping Cart
     */
    public function create() {
        $cart = ShoppingCartService::createCart();
        $cart ? $this->success(201) : $this->error();
        return $this->withData($cart);
    }

    /**
     * delete current shopping cart of current user 
     * @group Shopping Cart
     */
    public function delete() {
        return $this->tapCart(function($cart) {
            $cart->delete();
            return $this;
        });
    }

    /**
     * add Item to shopping cart
     * @group Shopping Cart
     */
    public function addItem(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            if ($item = ShoppingCartService::addProduct($cart, 
                $request->get('product_id'),
                $request->get('quantity', 1),
                $request->get('options', []))) 
            {
                return $this->withData($cart);
            } else {
                $this->error(400, 'fail to add item to cart');
            }
        }, true);
    }

    /**
     * update a shopping cart item's quantity
     * @group Shopping Cart
     */
    public function updateItemQuantity() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::updateItemQuantity($cart, Route::input('item_id'), Route::input('quantity'))) {
                return $this->success(200)->withData($cart);
            } else {
                $this->error(400, 'Can not update quantity for item ' . Route::input('item_id'));
            }
        }, true);
    }

    /**
     * delete a shopping cart item
     * @group Shopping Cart
     */
    public function deleteItem() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::deleteItem($cart, Route::input('item_id'))) {
                return $this->withData($cart);
            } else {
                $this->error(400, 'fail to delete item');
            }
        });
    }

    /**
     * update shopping cart item
     * @group Shopping Cart
     */
    public function updateItem() {
        ShoppingCartService::updateItem();
    }

    /**
     * try to apply coupon code for a shopping cart
     * @group Shopping Cart
     */
    public function putCoupon() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::addCoupon($cart, Route::input('coupon'))) {
                return $this->withData($cart);
            } else {
                $this->error(400, 'Coupon is not valid."');
            }
        });
    }

    /**
     * try to get current coupon code from a shopping cart
     * @group Shopping Cart
     */
    public function getCoupon() {
        ShoppingCartService::addCoupon();
    }

    /**
     * cancel a coupon
     * @group Shopping Cart
     */
    public function deleteCoupon() {
        ShoppingCartService::deleteCoupon();
    }

    /**
     * set current shopping cart's billing address
     * @group Shopping Cart
     */
    public function setBillingAddress(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $address = new ShoppingCartAddress($request->all());
            ShoppingCartService::setBillingAddress($cart, $address, $request->get('ship_to_billingaddesss'));
            return $this->withData($cart);
        });
    }

    /**
     * set current shopping cart's shipping address
     * @group Shopping Cart
     */
    public function setShippingAddress(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $address = new ShoppingCartAddress($request->all());
            ShoppingCartService::setShippingAddress($cart, $address);
            return $this->withData($cart);
        });
    }

    /**
     * merge a shopping cart to anohter shopping cart
     * @group Shopping Cart
     */
    public function mergeCart() {
        return $this->tapCart(function($cart) {
            if ($to_cart = ShoppingCartService::cart(Route::input('to_cart_guid'))) {
                foreach($cart->items as $item) {
                    ShoppingCartService::addItem($to_cart, $item, false);
                }
                ShoppingCartService::ShoppingCartUpdated($to_cart);
                // $cart->abandoned()->update();
            }
        });
    }

    /**
     * get current shopping cart's customer details
     * @group Shopping Cart
     */
    public function getCustomer() {

    }

    /**
     * attach a customer to a shopping cart
     * @group Shopping Cart
     */
    public function setCustomer(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            if ($cart->mode == 0) {
                $cart->customer_id = Route::input('customer_id');
                $cart->mode = 1;
                $cart->save();
                return $this->withData($cart);
            } else {
                return $this->error();
            }
        });
    }

    /**
     * update a shopping cart's email address
     * @group Shopping Cart
     */
    public function updateEmail(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $cart->email = $request->get('email');
            $cart->save();
            return $this->withData($cart);
        });
    }
}