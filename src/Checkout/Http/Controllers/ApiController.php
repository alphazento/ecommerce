<?php

namespace Zento\Checkout\Http\Controllers;

use Auth;
use Request;
use Registry;

use Illuminate\Support\Collection;
use Zento\Contracts\ROModel\ROPaymentTransaction;
use Zento\Contracts\ROModel\ROShoppingCart;
use Zento\Checkout\Providers\Facades\CheckoutService;

class ApiController extends \App\Http\Controllers\Controller
{
    /**
     * only for guest user
     *
     * @return void
     */
    public function setGuestDetails() {
        $details = Request::all();
        $user = Auth::user();
        
        $id = $details['id'] ?? 0;
        unset($details['id']);

        foreach($details ?? [] as $key => $value) {
            $user->{$key} = $value;
        }
        if (!$user->id) {
            $user->id = $id;
        }
        $user->save();
        return ['status' => 200, 'data' => Auth::user()];
    }
}