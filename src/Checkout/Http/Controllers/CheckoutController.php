<?php

namespace Zento\Checkout\Http\Controllers;


use Route;
use Request;
use Registry;
use ShoppingCartService;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends \App\Http\Controllers\Controller
{

    public function index() {
        return (new \Zento\CMS\Services\LayoutService)->render('checkout', 'page.checkout',  ['cart'=> ShoppingCartService::myCart()]);
    }
}