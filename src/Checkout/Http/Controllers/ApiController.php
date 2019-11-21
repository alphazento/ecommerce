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

class ApiController extends ApiBaseController
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
        return $this->withData(Auth::user());
    }
}