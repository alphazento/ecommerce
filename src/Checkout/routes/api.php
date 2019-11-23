<?php
Route::group(
    [
        'prefix' => '/api/v1/checkout',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::put(
            '/guest/details',
            ['as' => 'api.checkout.put.guest-details', 'uses' => 'ApiController@putGuestDetails']
        );
    }
);