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

    public function newCart() {
        $cart = ShoppingCartService::newCart();
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
            ShoppingCartService::updateItemQuantity($cart->getId(), Route::input('item_id'), Route::input('quantity'));
        }
        return redirect()->to(route('cart.index'));
    }

    public function deleteItem() {
        if ($cart = $this->retrieveCart()) {
            ShoppingCartService::deleteItem(Route::input('id'));
        }
        return redirect()->to(route('cart.index'));
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