<?php

namespace Zento\PaymentGateway\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;
use Route;

class UtilityController extends Controller
{
    public function prePayment()
    {
        return (new \Zento\PaymentGateway\Events\PrePayment(Route::input('method'), Request::all()))
            ->fireUntil();
    }

    public function cancelPayment()
    {
        return (new \Zento\PaymentGateway\Events\cancelPayment(Route::input('method'), Request::all()))
            ->fireUntil();
    }

    public function postPayment()
    {
        return (new \Zento\PaymentGateway\Events\PostPayment(Route::input('method'), Request::all()))
            ->fireUntil();
    }
}
