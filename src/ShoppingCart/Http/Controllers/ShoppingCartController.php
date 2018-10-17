<?php

namespace Zento\ShoppingCart\Http\Controllers;


use Route;
use Request;
use Registry;
use Product;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    protected function getMyCart() {
        if ($cart = ShoppingCartService::myCart()) {
            return $cart;
        } 
        if ($cart = ShoppingCartService::newCart()) {
            return $cart;
        }
    }

    public function index() {
        return view('pages.cart', ['cart' => ShoppingCartService::myCart()]);
    }

    public function addProduct() {
        if ($cart = $this->getMyCart()) {
            ShoppingCartService::addProductById(Request::get('product_id'), Request::get('quantity'), null);
        }
        return redirect()->to(route('cart.index'));
    }

    public function updateItemQuantity() {
        if ($cart = $this->getMyCart()) {
            ShoppingCartService::updateItemQuantity($cart->getId(), Route::input('item_id'), Route::input('quantity'));
        }
        return redirect()->to(route('cart.index'));
    }

    public function deleteItem() {
        if ($cart = $this->getMyCart()) {
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