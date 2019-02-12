<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        'middleware' => ['setuppassport', 'auth:api']
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