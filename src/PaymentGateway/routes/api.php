<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
    ], function () {
        Route::post(
            '/payment/estimate',
            ['as' => 'payment.estimate', 'uses' => 'ApiController@estimate']
        );

        Route::post(
            '/payment/capture/{method}',
            ['as' => 'payment.capture', 'uses' => 'ApiController@capture']
        );
    }
);
