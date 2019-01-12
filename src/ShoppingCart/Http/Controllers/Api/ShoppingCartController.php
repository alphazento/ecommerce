<?php

namespace Zento\ShoppingCart\Http\Controllers\Api;


use Auth;
use Route;
use Request;
use Response;
use Registry;
use ShoppingCartService;

use Zento\ShoppingCart\Model\ORM\ShoppingCart;
use Zento\ShoppingCart\Model\ORM\ShoppingCartAddress;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    public function getCart() {
        return $this->tapCart(function($cart) {
            return ['status'=>200, 'data' => $cart];
        });
    }

    public function createCart() {
        $cart = ShoppingCartService::createCart();
        return ['status'=> ($cart ? 201 : 420), 'data' => $cart];
    }

    public function addItem() {
        return $this->tapCart(function($cart) {
            if ($item = ShoppingCartService::addProductById($cart, Request::get('product_id'), Request::get('quantity'), [])) {
                return ['status'=> 201, 'data' => ['cart_id' => $cart->guid]];
            } else {
                return ['status'=> 420, 'error' => 'fail to add item to cart'];
            }
        });
    }

    public function updateItemQuantity() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::updateItemQuantity($cart, Route::input('item_id'), Route::input('quantity'))) {
                return ['status'=> 200, 'data' => null];
            } else {
                return ['status'=> 420, 'data' => ['Can not update quantity for item ' . Route::input('item_id')]];
            }
        });
    }

    public function deleteItem() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::deleteItem($cart, Route::input('item_id'))) {
                return ['status'=> 200, 'data' => null];
            } else {
                return ['status'=> 420, 'error' => 'fail to delete item ' . Route::input('item_id')];
            }
        });
    }

    public function updateItem() {
        ShoppingCartService::updateItem();
    }

    public function putCoupon() {
        ShoppingCartService::addCoupon();
    }

    public function getCoupons() {
        ShoppingCartService::addCoupon();
    }

    public function deleteCoupons() {
        ShoppingCartService::deleteCoupons();
    }

    public function setBillingAddress() {
        return $this->tapCart(function($cart) {
            $address = new ShoppingCartAddress(Request::all());
            ShoppingCartService::setBillingAddress($cart, $address, Request::get('ship_to_billingaddesss'));
            return ['status'=> 200, 'data' => null];
        });
    }

    public function getBillingAddress() {

    }

    public function setShippingAddress() {

    }

    public function getShippingAddress() {

    }

    public function mergeCart() {
        return $this->tapCart(function($cart) {
            if ($to_cart = ShoppingCartService::cart(Route::input('to_cart_guid'))) {
                foreach($cart->items as $item) {
                    ShoppingCartService::addItem($to_cart, $item, false);
                }
                ShoppingCartService::shoppingCartModified($to_cart);
                // $cart->abandoned()->update();
            }
        });
    }

    public function getCustomer() {

    }

    public function setCustomer() {
        return $this->tapCart(function($cart) {
            if ($cart->mode == 0 && $cart->guest_guid == Request::get('client_guid')) {
                $cart->customer_id = Route::input('customer_id');
                $cart->mode = 1;
                $cart->save();
                return ['status' => 200];
            } else {
                return ['status' => 420, 'error' => 'the cart is not guest mode'];
            }
        });
    }

    protected function tapCart(\Closure $callbak) {
        $cart_guid = Route::input('cart_guid');
        if ($cart_guid === 'mine') {
            if (!Auth::check()) {
                return response('', 401);
            } elseif($cart = ShoppingCartService::getMyCart()) {
                return \call_user_func($callbak, $cart);
            }
        }
        
        if ($cart_guid && $cart = ShoppingCartService::cart($cart_guid)) {
            $guest_guid = Request::header('guest-guid');
            if (Auth::user()) {
                if (Auth::user()->id === $cart->customer_id) {
                    //is my cart
                    return \call_user_func($callbak, $cart);
                }
                if (empty($cart->customer_id) && $guest_guid == $cart->guest_guid) {
                    // guest cart but match requester's guest_guid
                    return \call_user_func($callbak, $cart);
                }
            } else {
                if (!empty($cart->customer_id)) {
                    //it belongs to some customer, but requester is guest
                    return ['status'=> 405, 'error' => 'Not allow to request.'];
                } elseif ($guest_guid == $cart->guest_guid) {
                    //guest requester and match guest card
                    return \call_user_func($callbak, $cart);
                }
            }
        }
        return ['status'=> 404, 'error' => 'cart not found.'];
    }
}