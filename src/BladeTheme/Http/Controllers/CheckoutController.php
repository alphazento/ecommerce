<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
use Route;
use Request;
use BladeTheme;
use PaymentGateway;

class CheckoutController extends \App\Http\Controllers\Controller
{
    use TraitThemeRouteOverwritable;

    public function index() {
        $cart = $this->getCart();
        $user = Auth::user();
        $paymentmethods = PaymentGateway::estimate($cart, $user, null, 'vue');
        return BladeTheme::addGlobalViewData(
            [
                'consts' => compact('paymentmethods')
            ]
        )->breadcrumb(route('checkout.page'), 'Checkout')
        ->view('page.checkout.index', compact('cart'));
    }
    
    public function success() {
        if ($order_number = Request::session()->pull('order_number')) {
            return BladeTheme::view('page.checkout.success', compact('order_number'));
        } 
        return redirect()->to('/');
    }
}
