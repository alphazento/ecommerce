<?php
Route::group(
    [
        'prefix' => '/ajax/checkout',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::put(
            '/guest-customer',
            ['as' => 'ajax.checkout.put.guest-customer', 'uses' => 'ApiController@setGuestDetails']
        );
    }
);