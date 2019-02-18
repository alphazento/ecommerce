<?php
Route::group(
    [
        'prefix' => '/rest/v1/sales',
        'namespace' => '\Zento\Sales\Http\Controllers\Api',
        'middleware' => ['cors']
        // 'middleware' => ['web']
    ], function () {
    Route::post(
        '/orders/create', 
        ['as' => 'orders.create', 'uses' => 'SalesController@createOrder']
    );
    // PUT    /V1/orders/:parent_id
});