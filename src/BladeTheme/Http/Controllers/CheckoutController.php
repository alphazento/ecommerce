<?php

namespace Zento\BladeTheme\Http\Controllers;

use Auth;
use Route;
use Request;
use BladeTheme;
use PaymentGateway;

class CheckoutController extends ShoppingCartController
{
    public function page() {
        $cart = $this->getCart();
        $user = Auth::user();
        $paymentmethods = PaymentGateway::estimate($cart, $user, null, 'vue');
        return BladeTheme::breadcrumb('/', 'Home')
            ->breadcrumb(route('web.get.checkout'), 'Checkout')
            ->view('page.checkout', compact('cart', 'user', 'paymentmethods'));
    }
    
    public function process() {
        $cart = $this->getCart();
    }

    public function success() {
        return view('page.order-success');
    }
}
