<?php
Route::group(
    [
        'prefix' => '/api/v1/sales',
        'namespace' => '\Zento\Sales\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
    ], function () {
        Route::post(
            '/orders',
            ['as' => 'orders.create', 'uses' => 'SalesController@createOrder']
        );

        // Route::patch( '/orders/{id}',
        //     ['as' => 'orders.update', 'uses' => 'SalesController@updateOrder']
        // );
    });
