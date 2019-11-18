<?php
Route::group(
    [
        'prefix' => '/api/v1/checkout',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::put(
            '/guest-customer',
            ['as' => 'ajax.checkout.put.guest-customer', 'uses' => 'ApiController@setGuestDetails']
        );

        Route::post(
            '/orders',
            ['as' => 'checkout.post.draftorder', 'uses' => 'ApiController@draftOrder']
        );
    }
);