<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\PaypalPayment\Http\Controllers',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/paypal_config', 
            [
                'as' => 'paypay.config',
                 'uses' => 'ApiController@renderPaypalConfigJs'
            ]
        );
});