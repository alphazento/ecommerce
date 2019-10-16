<?php

namespace Zento\ShoppingCart\Http\Controllers\Api;

use Auth;
use Route;
use Request;
use Registry;
use ShoppingCartService;

class ShoppingCartController extends \Zento\ShoppingCart\Http\Controllers\Api\ShoppingCartController
{
    protected function tapCart(\Closure $callbak, $forceCreateForMine = false) {
        $cart_guid = Route::input('cart_guid');
        if ($cart_guid === 'mine') {
            if (!Auth::check()) {
                return response('', 401);
            } elseif ($cart = ShoppingCartService::getMyCart($forceCreateForMine)) {
                return \call_user_func($callbak, $cart);
            }
        }
        
        if ($cart_guid && $cart = ShoppingCartService::cart($cart_guid)) {
            $guest_guid = Request::header('guest-guid');
            if (Auth::user()) {
                if (Auth::user()->id === $cart->customer_id) {
                    //is my cart
                    return \call_user_func($callbak, $cart);
                }
                if (empty($cart->customer_id) && $guest_guid == $cart->guest_guid) {
                    // guest cart but match requester's guest_guid
                    return \call_user_func($callbak, $cart);
                }
            } else {
                if (!empty($cart->customer_id)) {
                    //it belongs to some customer, but requester is guest
                    return ['status'=> 405, 'error' => 'Not allow to request.'];
                } elseif ($guest_guid == $cart->guest_guid) {
                    //guest requester and match guest card
                    return \call_user_func($callbak, $cart);
                }
            }
        }
        return ['status'=> 404, 'error' => 'cart not found.'];
    }
}