<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\PaypalPayment\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::get(
            '/paypal_config', 
            [
                'as' => 'paypay.config',
                 'uses' => 'ApiController@renderPaypalConfigJs'
            ]
        );
});