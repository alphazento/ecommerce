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
        return BladeTheme::breadcrumb(route('web.get.checkout'), 'Checkout')
            ->view('page.checkout.index', compact('cart', 'paymentmethods'));
    }
    
    public function success() {
        return BladeTheme::view('page.checkout.success');
    }
}
