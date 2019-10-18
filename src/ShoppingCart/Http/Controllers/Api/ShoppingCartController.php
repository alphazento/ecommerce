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

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    use TraitShoppingCartHelper;
    public function getCart() {
        return $this->tapCart(function($cart) {
            return ['status'=>200, 'data' => $cart];
        });
    }

    public function createCart() {
        $cart = ShoppingCartService::createCart();
        return ['status'=> ($cart ? 201 : 420), 'data' => $cart];
    }

    public function addItem(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            if ($item = ShoppingCartService::addProductById($cart, 
                $request->get('product_id'), 
                $request->get('quantity', 1),
                $request->get('url'),
                $request->get('options', []))) {
                return ['status'=> 201, 'data' => ['cart_id' => $cart->guid]];
            } else {
                return ['status'=> 420, 'error' => 'fail to add item to cart'];
            }
        }, true);
    }

    public function updateItemQuantity() {
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::updateItemQuantity($cart, Route::input('item_id'), Route::input('quantity'))) {
                return ['status'=> 200, 'data' => null];
            } else {
                return ['status'=> 420, 'data' => ['Can not update quantity for item ' . Route::input('item_id')]];
            }
        }, true);
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
        return $this->tapCart(function($cart) {
            if (ShoppingCartService::addCoupon($cart, Route::input('coupon'))) {
                return ['status'=> 200, 'data' => $cart];
            } else {
                return ['status'=> 420, 'data' => "Coupon is not valid."];
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
                ShoppingCartService::ShoppingCartUpdated($to_cart);
                // $cart->abandoned()->update();
            }
        });
    }

    public function getCustomer() {

    }

    public function setCustomer(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            if ($cart->mode == 0 && $cart->guest_guid == $request->get('client_guid')) {
                $cart->customer_id = Route::input('customer_id');
                $cart->mode = 1;
                $cart->save();
                return ['status' => 200];
            } else {
                return ['status' => 420, 'error' => 'the cart is not guest mode'];
            }
        });
    }

    public function updateEmail(Request $request) {
        return $this->tapCart(function($cart) use ($request) {
            $cart->email = $request->get('email');
            $cart->save();
            return ['status' => 200];
        });
    }
}