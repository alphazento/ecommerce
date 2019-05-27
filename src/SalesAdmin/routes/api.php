<?php
Route::group(
    [
        'prefix' => '/api/v1/admin/sales',
        'namespace' => '\Zento\SalesAdmin\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
        'as' => 'admin:sales:'
    ], function () {
    Route::get(
        '/orders', 
        ['as' => 'orders.gets', 'uses' => 'ApiController@getOrders']
    );
    
    Route::get(
        '/orders/:id', 
        ['as' => 'orders.get', 'uses' => 'ApiController@getOrder']
    );

    Route::get(
        '/orders/:id/statuses', 
        ['as' => 'orders.getstatuses', 'uses' => 'ApiController@getOrderStatuses']
    );

    Route::post(
        '/orders/:id/emails', 
        ['as' => 'orders.setemails', 'uses' => 'ApiController@setOrderEmails']
    );

    Route::post(
        '/orders/:id/hold', 
        ['as' => 'orders.hold', 'uses' => 'ApiController@holdOrder']
    );

    Route::post(
        '/orders/:id/unhold', 
        ['as' => 'orders.hold', 'uses' => 'ApiController@unholdOrder']
    );

    Route::get(
        '/orders/:id/comments', 
        ['as' => 'orders.getcomments', 'uses' => 'ApiController@getComments']
    );

    Route::post(
        '/orders/:id/comments', 
        ['as' => 'orders.setcomments', 'uses' => 'ApiController@setComments']
    );

    // PUT    /V1/orders/:parent_id
});