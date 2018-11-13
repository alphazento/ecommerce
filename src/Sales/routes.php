<?php
Route::group(
    [
        'prefix' => '/rest/v1/sales',
        'namespace' => '\Zento\Sales\Http\Controllers\Api',
        'middleware' => ['cors']
        // 'middleware' => ['web']
    ], function () {
    Route::get(
        '/orders', 
        ['as' => 'orders.gets', 'uses' => 'SalesController@getOrders']
    );
    
    Route::get(
        '/orders/:id', 
        ['as' => 'orders.get', 'uses' => 'SalesController@getOrder']
    );

    Route::get(
        '/orders/:id/statuses', 
        ['as' => 'orders.getstatuses', 'uses' => 'SalesController@getOrderStatuses']
    );

    Route::post(
        '/orders/:id/emails', 
        ['as' => 'orders.setemails', 'uses' => 'SalesController@setOrderEmails']
    );

    Route::post(
        '/orders/:id/hold', 
        ['as' => 'orders.hold', 'uses' => 'SalesController@holdOrder']
    );

    Route::post(
        '/orders/:id/unhold', 
        ['as' => 'orders.hold', 'uses' => 'SalesController@unholdOrder']
    );

    Route::get(
        '/orders/:id/comments', 
        ['as' => 'orders.getcomments', 'uses' => 'SalesController@getComments']
    );

    Route::post(
        '/orders/:id/comments', 
        ['as' => 'orders.setcomments', 'uses' => 'SalesController@setComments']
    );

    Route::put(
        '/orders/create', 
        ['as' => 'orders.create', 'uses' => 'SalesController@createOrder']
    );
    // PUT    /V1/orders/:parent_id
});