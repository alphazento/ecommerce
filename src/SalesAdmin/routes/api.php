<?php
Route::group(
    [
        'prefix' => '/api/v1/admin/sales',
        'namespace' => '\Zento\SalesAdmin\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
    ], function () {
        Route::get(
            '/orders',
            ['as' => 'orders.gets', 'uses' => 'ApiController@getOrders']
        );

        Route::get(
            '/orders/statuses',
            ['as' => 'orders.getstatuses', 'uses' => 'ApiController@getOrderStatuses']
        );

        Route::get(
            '/orders/{id}',
            ['as' => 'orders.get', 'uses' => 'ApiController@getOrder']
        );

        Route::post(
            '/orders/{id}/status/{status_id}',
            ['as' => 'orders.put.status', 'uses' => 'ApiController@setOrderStatus']
        );

        Route::post(
            '/orders/{id}/hold',
            ['as' => 'orders.hold', 'uses' => 'ApiController@holdOrder']
        );

        Route::post(
            '/orders/{id}/unhold',
            ['as' => 'orders.unhold', 'uses' => 'ApiController@unholdOrder']
        );

        Route::get(
            '/orders/{id}/comments',
            ['as' => 'orders.getcomments', 'uses' => 'ApiController@getComments']
        );

        Route::post('/orders/{id}/comments', 'ApiController@setComments');

        Route::post(
            '/notes',
            ['as' => 'orders.addadminnote', 'uses' => 'ApiController@addAdminNote']
        );

        // PUT    /V1/orders/:parent_id
    });
