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
    public function getCart() {
        return $this->tapCart(function($cart) {
            return $this->withData($cart);
        });
    }

    public function createCart() {
        $cart = ShoppingCartService::createCart();
        $cart ? $this->success(201) : $this->error();
        return $this->withData($cart);
    }

    public function addItem(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            if ($item = ShoppingCartService::addProductById($cart, 
                $request->get('product_id'), 
                $request->get('actual_product_id'),
                $request->get('quantity', 1),
                $request->get('url'),
                $request->get('options', []))) {
                return $this->withData($cart);
            } else {
                $this->error(400, 'fail to add item to cart');
            }
        }, true);
    }

    public function updateItemQuantity() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::updateItemQuantity($cart, Route::input('item_id'), Route::input('quantity'))) {
                return $this->success(200)->withData($cart);
            } else {
                $this->error(400, 'Can not update quantity for item ' . Route::input('item_id'));
            }
        }, true);
    }

    public function deleteItem() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::deleteItem($cart, Route::input('item_id'))) {
                return $this->withData($cart);
            } else {
                $this->error(400, 'fail to delete item');
            }
        });
    }

    public function updateItem() {
        ShoppingCartService::updateItem();
    }

    public function putCoupon() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::addCoupon($cart, Route::input('coupon'))) {
                return $this->withData($cart);
            } else {
                $this->error(400, 'Coupon is not valid."');
            }
        });
    }

    public function getCoupon() {
        ShoppingCartService::addCoupon();
    }

    public function deleteCoupon() {
        ShoppingCartService::deleteCoupon();
    }

    public function setBillingAddress(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $address = new ShoppingCartAddress($request->all());
            ShoppingCartService::setBillingAddress($cart, $address, $request->get('ship_to_billingaddesss'));
            return $this->withData($cart);
        });
    }

    public function setShippingAddress(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $address = new ShoppingCartAddress($request->all());
            ShoppingCartService::setShippingAddress($cart, $address);
            return $this->withData($cart);
        });
    }

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

    public function getCustomer() {

    }

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

    public function updateEmail(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $cart->email = $request->get('email');
            $cart->save();
            return $this->withData($cart);
        });
    }
}