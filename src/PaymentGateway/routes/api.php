<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        'middleware' => ['setuppassport', 'auth:api'],
        'as' => 'payment:'
    ], function () {
        Route::post(
            '/payment/estimate', 
            ['as' => 'home', 'uses' => 'ApiController@estimate']
        );

        Route::post(
            '/payment/prepare/{method}', 
            ['as' => 'payment.prepare', 'uses' => 'ApiController@prepare']
        );

        Route::post(
            '/payment/capture/{method}', 
            ['as' => 'payment.capture', 'uses' => 'ApiController@capture']
        );
    }
);