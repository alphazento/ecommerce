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
        '/me/addresses', 
        ['as' => 'customer.me.addresses', 'uses' => 'CustomerController@getMyAddresses']
    );

    Route::get(
        '/me/addresses/{id}', 
        ['as' => 'customer.me.addresses', 'uses' => 'CustomerController@getMyAddress']
    );

    Route::put(
        '/me/default_billing_address/{id}', 
        ['as' => 'customer.put.mydefault_billing_address', 'uses' => 'CustomerController@setMyDefaultBillingAddress']
    );

    Route::put(
        '/me/default_shipping_address/{id}', 
        ['as' => 'customer.put.mydefault_shipping_address', 'uses' => 'CustomerController@setMyDefaultShippingAddress']
    );

    Route::post(
        '/me/addresses/add', 
        ['as' => 'customer.me.add.address', 'uses' => 'CustomerController@addMyAddress']
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

    Route::post(
        '/{customer_id}/addresses/add', 
        ['as' => 'customer.add.address', 'uses' => 'CustomerController@addCustomerAddress']
    );
});