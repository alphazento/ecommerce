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

        Route::post(
            '/payment/presubmit/{method}', 
            ['as' => 'home', 'uses' => 'ApiController@presubmit']
        );

        Route::post(
            '/payment/submit/{method}', 
            ['as' => 'home', 'uses' => 'ApiController@submit']
        );

        Route::post(
            '/payment/postsubmit/{method}', 
            ['as' => 'home', 'uses' => 'ApiController@postsubmit']
        );
    }
);