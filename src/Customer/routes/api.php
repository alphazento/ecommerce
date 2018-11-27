<?php
Route::group(
    [
        'prefix' => '/rest/v1/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['apipassport', 'auth:api']
    ], function () {
    Route::get(
        '/me', 
        ['as' => 'customer.get.me', 'uses' => 'CustomerController@me']
    );

    Route::put(
        '/me', 
        ['as' => 'customer.put.me', 'uses' => 'CustomerController@updateMe']
    );

    Route::put(
        '/me/activate', 
        ['as' => 'customer.get.me', 'uses' => 'CustomerController@activateMe']
    );

    Route::get(
        '/{customer_id}', 
        ['as' => 'customer.getbyid', 'uses' => 'CustomerController@getCustomer']
    );

    Route::put(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@activateCustomer']
    );

    Route::put(
        '/{customer_id}', 
        ['as' => 'customer.putbyid', 'uses' => 'CustomerController@setCustomer']
    );

    Route::put(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@setCustomer']
    );
});