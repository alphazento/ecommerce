<?php
Route::group(
    [
        'prefix' => '/rest/v1/customer',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors']
        // 'middleware' => ['web']
    ], function () {
    Route::get(
        '/orders', 
        ['as' => 'orders.gets', 'uses' => 'CustomerController@getOrders']
    );
});