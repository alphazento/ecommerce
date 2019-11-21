<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
use Route;
use Request;
use Redirect;
use BladeTheme;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    use TraitThemeRouteOverwritable;

    protected function createCart() {
        $resp = BladeTheme::requestInnerApi('POST', 
            $this->genApiUrl('cart'));
        if ($resp->success) {
            return $resp->data;
        }
        return null;
    }

    public function index() {
        $protocal = Route::input('protocal', 'web');
        $resp = $this->getCart(true);
        if ($protocal === 'web') {
            $cart = $resp->data;
            return BladeTheme::breadcrumb(route('web.get.cart'), 'Shopping Cart')
                ->view('page.shoppingcart', compact('cart'));
        } else {
            if ($protocal === 'ajax') {
                return $resp;
            }
        }
    }

    public function addItem() {
        $product_id = Route::input('pid');
        $protocal = Route::input('protocal', 'web');

        $cart = $this->getCart();
        if (!$cart) {
            $cart = $this->createCart();
        }

        $quantity = Request::get('qty', 1);
        $options = Request::get('options', []);
        $url = Request::get('url', 'https://alphazento.local.test/xl-518.html');
        $resp = BladeTheme::requestInnerApi('POST', 
            $this->genApiUrl('cart/items'),
            compact('product_id', 'quantity', 'options', 'url')
        );
        
        if ($protocal === 'web') {
            if($resp->success) {
                return redirect()->route('web.get.cart')
                    ->withMessage('Product has been added to Shopping Cart.');
            } else {
                return Redirect::back()->withErrors([$resp->message]);
            }
        } else {
            return $resp;
        }
        return Redirect::back()->withErrors(['Fail to add product to your Shopping Cart.']);
    }

    public function deleteItem() {
        $item_id = Route::input('item_id');
        $protocal = Route::input('protocal', 'web');
        
        if ($cart = $this->getCart()) {
            $resp = BladeTheme::requestInnerApi('DELETE', 
                $this->genApiUrl(sprintf('cart/items/%s', $item_id))
            );

            if ($protocal === 'web') {
                if ($resp->success) {
                    return redirect()->route('web.get.cart')
                        ->withMessage('Product has been added to Shopping Cart.');
                } else {
                    return Redirect::back()->withErrors([$resp->message]);
                }
            } else {
                return $resp;
            }
        }
        return Redirect::back()->withErrors(['Fail to delete product from your Shopping Cart.']);
    }

    public function updateItemQty() {

    }
}