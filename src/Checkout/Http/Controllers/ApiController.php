<?php

namespace Zento\Checkout\Http\Controllers;

use Auth;
use Request;
use Registry;

use Illuminate\Support\Collection;
use Zento\Contracts\ROModel\ROPaymentTransaction;
use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\Checkout\Providers\Facades\CheckoutService;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\ShoppingCart\Http\Controllers\Api\TraitShoppingCartHelper;
use Zento\ShoppingCart\Providers\Facades\ShoppingCartService;

class ApiController extends ApiBaseController
{
    use TraitShoppingCartHelper;
    /**
     * only for guest user
     *
     * @return void
     */
    public function putGuestDetails() {
        $details = Request::all();
        $user = Auth::user();
        
        $id = $details['id'] ?? 0;
        unset($details['id']);

        foreach($details ?? [] as $key => $value) {
            $user->{$key} = $value;
        }
        $user->save();
        $this->tapCart(function($cart) use($user) {
            ShoppingCartService::updateCustomerDetails($cart, $user);
        });
        return $this->withData(Auth::user());
    }
}