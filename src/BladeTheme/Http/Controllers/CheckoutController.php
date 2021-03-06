<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
use BladeTheme;
use PaymentGateway;
use Request;
use Route;

class CheckoutController extends \App\Http\Controllers\Controller
{
    use TraitCartHelper;

    /**
     * Render shopping cart page
     * @group Web Pages
     */
    public function index()
    {
        $cart = $this->getCart();
        $user = Auth::user();
        $paymentmethods = PaymentGateway::estimate($cart, $user, null, 'vue');
        return BladeTheme::addGlobalViewData(
            [
                'appData' => [
                    'consts' => compact('paymentmethods'),
                ],
            ]
        )->breadcrumb(route('checkout.page'), 'Checkout')
            ->view('page.checkout.index', compact('cart'));
    }

    /**
     * Render checkout success page
     * @group Web Pages
     */
    public function success()
    {
        if ($order_number = Request::session()->pull('order_number')) {
            return BladeTheme::view('page.checkout.success', compact('order_number'));
        }
        return redirect()->to('/');
    }
}
