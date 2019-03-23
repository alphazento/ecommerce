<?php

namespace Zento\BaseTheme\Http\Controllers;


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
        return (new \Zento\CMS\Services\LayoutService)->render('checkout', 'page.cart',  ['cart'=> ShoppingCartService::myCart()]);
        // return view('pages.cart', ['cart' => ShoppingCartService::myCart()]);
    }

    public function addProduct() {
        $item = null;
        if ($cart = $this->getMyCart()) {
            $item =  ShoppingCartService::addProductById(Request::get('product_id'), Request::get('quantity'), []);
        }
        if (Request::ajax()) {
            return  ['success' => $item ? sprintf('%s has been added.', $item->name) : false, 'total' => $cart->total ?? 0];
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