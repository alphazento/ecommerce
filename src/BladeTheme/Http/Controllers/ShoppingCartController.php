<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
use Route;
use Request;
use Redirect;
use BladeTheme;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    protected function getCart() {
        $cartId = Auth::user() ? 'mine' : (session()->getId());
        if ($resp = BladeTheme::innerApiProxy('GET', sprintf('/api/v1/cart/%s', $cartId))) {
            if ($resp['status'] == 404) {
                return null;
            } else {
                return $resp['data'];
            }
        }
        return null;
    }

    protected function createCart() {
        if ($resp = BladeTheme::innerApiProxy('POST', '/api/v1/cart')) {
            if ($resp['status'] == 404) {
                return null;
            } else {
                return $resp['data'];
            }
        }
        return null;
    }

    public function cartPage() {
        $cart = $this->getCart();
        return BladeTheme::breadcrumb(route('web.get.cart'), 'Shopping Cart')
                ->view('page.shoppingcart', compact('cart'));
    }

    public function addItem() {
        $product_id = Route::input('pid');
        $cart = $this->getCart();
        if (!$cart) {
            $cart = $this->createCart();
        }

        $quantity = Request::get('qty', 1);
        $options = Request::get('options', []);
        $url = Request::get('url', 'https://alphazento.local.test/xl-518.html');
        if ($resp = BladeTheme::innerApiProxy(
            'POST',
            sprintf('/api/v1/cart/%s/items', $cart->guid),
            compact('product_id', 'quantity', 'options', 'url')
        )) {
            if($resp['status'] == 201) {
                return redirect()->route('web.get.cart')
                    ->withMessage('Product has been added to Shopping Cart.');
            } else {
                return Redirect::back()->withErrors([$resp['error']]);
            }
        }
        return Redirect::back()->withErrors(['Fail to add product to your Shopping Cart.']);
    }

    public function deleteItem() {
        $item_id = Route::input('item_id');
        if ($cart = $this->getCart()) {
            if ($resp = BladeTheme::innerApiProxy(
                'DELETE',
                sprintf('/api/v1/cart/%s/items/%s', $cart->guid, $item_id)
            )) {
                if($resp['status'] != 420) {
                    return redirect()->route('web.get.cart')
                        ->withMessage('Product has been added to Shopping Cart.');
                } else {
                    return Redirect::back()->withErrors([$resp['error']]);
                }
            }
        }
        return Redirect::back()->withErrors(['Fail to delete product from your Shopping Cart.']);
    }

    public function updateItemQty() {

    }
}