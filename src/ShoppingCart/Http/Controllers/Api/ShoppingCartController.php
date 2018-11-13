<?php

namespace Zento\ShoppingCart\Http\Controllers\Api;


use Route;
use Request;
use Response;
use Registry;
use Product;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    public function getCart() {
        $cart = $this->retrieveCart();
        return ['status'=> ($cart ? 200 : 404), 'data' => $cart];
    }

    protected function retrieveCart() {
        $cart_guid = Route::input('guid');
        return $cart_guid ? ShoppingCartService::cart($cart_guid) : null;
    }

    public function createCart() {
        $cart = ShoppingCartService::createCart();
        return ['status'=> ($cart ? 201 : 420), 'data' => $cart];
    }

    public function addProduct() {
        $item = null;
        if ($cart = $this->retrieveCart()) {
            $item =  ShoppingCartService::addProductById($cart, Request::get('product_id'), Request::get('quantity'), []);
        }
        return ['status'=> ($item ? 201 : 420), 'data' => ['cart_id' => $cart->guid]];
    }

    public function updateItemQuantity() {
        if ($cart = $this->retrieveCart()) {
            if (ShoppingCartService::updateItemQuantity($cart, Route::input('item_id'), Route::input('quantity'))) {
                return ['status'=> 200, 'data' => null];
            } else {
                return ['status'=> 420, 'data' => ['Can not update quantity for item ' . Route::input('item_id')]];
            }
        } else {
            return ['status'=> 404, 'data' => [ 'Cart not found.' . Route::input('guid')]];
        }
    }

    public function deleteItem() {
        if ($cart = $this->retrieveCart()) {
            $success = ShoppingCartService::deleteItem($cart, Route::input('item_id'));
            return ['status'=> ($success ? 200 : 420), 'data' => null];
        }
        return ['status'=> ($success ? 200 : 404), 'data' => [ 'cart not found.' . Route::input('guid')]];
    }

    public function updateItem() {
        ShoppingCartService::updateItem();
    }

    public function addCoupon() {
        ShoppingCartService::addCoupon();
    }

    public function setBillingAddress() {

    }

    public function setShippingAddress() {

    }
}