<?php

namespace Zento\BladeTheme\Http\Controllers;

use BladeTheme;
use Redirect;
use Request;
use Route;

class ShoppingCartController extends \App\Http\Controllers\Controller
{
    use TraitCartHelper;

    protected function createCart()
    {
        $resp = BladeTheme::requestInnerApi('POST',
            BladeTheme::apiUrl('cart'));
        if ($resp->success) {
            return $resp->data;
        }
        return null;
    }

    /**
     * Render shopping cart page
     * @group Web Pages
     */
    public function index()
    {
        if ($resp = $this->getCart(true)) {
            $cart = $resp->data;
        } else {
            $cart = null;
        }
        return BladeTheme::breadcrumb(route('cart.page'), 'Shopping Cart')
            ->view('page.shoppingcart', compact('cart'));
    }

    /**
     * Add a product to shopping cart
     * @group Web Pages
     * @urlParam pid required number product id
     * @queryParam qty required number product's qty
     * @queryParam options required array product's qty
     * @queryParam url required string product's url
     */
    public function addItem()
    {
        $product_id = Route::input('pid');

        $cart = $this->getCart();
        if (!$cart) {
            $cart = $this->createCart();
        }

        $quantity = Request::get('qty', 1);
        $options = Request::get('options', []);
        // $url = Request::get('url', 'https://alphazento.local.test/xl-518.html');
        $url = '';
        $resp = BladeTheme::requestInnerApi('POST',
            BladeTheme::apiUrl('cart/items'),
            compact('product_id', 'quantity', 'options', 'url')
        );

        if ($resp->success) {
            return redirect()->route('cart.page')
                ->withMessage('Product has been added to Shopping Cart.');
        } else {
            return Redirect::back()->withErrors([$resp->message]);
        }

        return Redirect::back()->withErrors(['Fail to add product to your Shopping Cart.']);
    }

    /**
     * delete an item from shopping cart
     * @group Web Pages
     * @urlParam item_id required number shopping cart item id
     */
    public function deleteItem()
    {
        $item_id = Route::input('item_id');

        if ($cart = $this->getCart()) {
            $resp = BladeTheme::requestInnerApi('DELETE',
                BladeTheme::apiUrl(sprintf('cart/items/%s', $item_id))
            );

            if ($resp->success) {
                return redirect()->route('cart.page')
                    ->withMessage('Product has been added to Shopping Cart.');
            } else {
                return Redirect::back()->withErrors([$resp->message]);
            }
        }
        return Redirect::back()->withErrors(['Fail to delete product from your Shopping Cart.']);
    }

    /**
     * update an item qty from shopping cart
     * @group Web Pages
     * @urlParam item_id required number shopping cart item id
     * @queryParam qty required number shopping cart item new quantity
     */
    public function updateItemQty()
    {

    }
}
