<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
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
        if ($resp = BladeTheme::innerApiProxy('POST', sprintf('/api/v1/cart'))) {
            dd($resp);
            if ($resp['status'] == 404) {
                return null;
            } else {
                return $resp['data'];
            }
        }
        return null;
    }

    public function cartPage() {
        $quote = $this->getCart();
        return view('page.shoppingcart', compact('quote'));
    }

    public function addItem() {
        $cart = $this->getCart();
        if (!$cart) {
            $cart = $this->createCart();
            dd($cart);
        }
    }

    public function deleteItem() {
    
    }

    public function deleteItemQty() {

    }
}