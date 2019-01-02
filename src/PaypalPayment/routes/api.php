<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\PaypalPayment\Http\Controllers',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/paypal_config', 
            [ 'uses' => 'ApiController@renderPaypalConfigJs']
        );
});