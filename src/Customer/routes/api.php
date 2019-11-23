<?php
Route::group(
    [
        'prefix' => '/api/v1/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors', 'auth:api'],
        'as' => "api:user:"
    ], function () {
    Route::get(
        '/{customer_id}', 
        ['as' => 'customer.getbyid', 'uses' => 'CustomerController@getCustomer']
    );

    Route::patch(
        '/{customer_id}', 
        ['as' => 'customer.putbyid', 'uses' => 'CustomerController@setCustomer']
    );

    Route::patch(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@activateCustomer']
    );

    Route::patch(
        '/me/password', 
        ['as' => 'customer.mypassword', 'uses' => 'CustomerController@setMyPassword']
    );

    Route::patch(
        '/{customer_id}/password', 
        ['as' => 'customer.setpassword', 'uses' => 'CustomerController@setCustomerPassword']
    );

    Route::get(
        '/{customer_id}/addresses', 
        ['as' => 'customer.get.addresses', 'uses' => 'CustomerController@getAddresses']
    );

    Route::get(
        '/{customer_id}/address/{address_id}', 
        ['as' => 'customer.get.address', 'uses' => 'CustomerController@getAddress']
    );

    Route::post(
        '/{customer_id}/addresses/', 
        ['as' => 'customer.add.address', 'uses' => 'CustomerController@addAddress']
    );

    Route::patch(
        '/{customer_id}/default_billing_address/{address_id}', 
        ['as' => 'customer.put.mydefault_billing_address', 'uses' => 'CustomerController@setDefaultBillingAddress']
    );

    Route::patch(
        '/{customer_id}/default_shipping_address/{address_id}', 
        ['as' => 'customer.put.mydefault_shipping_address', 'uses' => 'CustomerController@setDefaultShippingAddress']
    );
});

//admin
Route::group(
    [
        'prefix' => '/api/v1/admin/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors', 'backend'],
    ], function () {
    //admin only
    Route::patch(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@activateCustomer']
    );

    Route::delete(
        '/{customer_id}/addresses/{id}', 
        ['as' => 'customer.add.address', 'uses' => 'CustomerController@addCustomerAddress']
    );
});