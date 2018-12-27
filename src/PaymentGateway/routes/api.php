<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\PaymentGateway\Http\Controllers',
        // 'middleware' => ['web']
        // 'middleware' => ['cors', 'auth:api']
        'middleware' => ['cors']
    ], function () {
        Route::post(
            '/payment/estimate', 
            ['as' => 'home', 'uses' => 'ApiController@estimate']
        );
    }
);