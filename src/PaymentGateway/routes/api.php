<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
        'as' => 'api:payment:'
    ], function () {
        Route::post(
            '/payment/estimate', 
            ['as' => 'estimate', 'uses' => 'ApiController@estimate']
        );

        Route::post(
            '/payment/prepare/{method}', 
            ['as' => 'prepare', 'uses' => 'ApiController@prepare']
        );

        Route::post(
            '/payment/capture/{method}', 
            ['as' => 'capture', 'uses' => 'ApiController@capture']
        );
    }
);