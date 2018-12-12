<?php
Route::group(
    [
        'prefix' => '/rest/v1/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['apipassport', 'auth:api']
    ], function () {
    Route::get(
        '/{customer_id}', 
        ['as' => 'customer.getbyid', 'uses' => 'CustomerController@getCustomer']
    );

    Route::put(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@activateCustomer']
    );

    Route::put(
        '/me/setpassword', 
        ['as' => 'customer.setmypassword', 'uses' => 'CustomerController@setMyPassword']
    );

    Route::put(
        '/{customer_id}/setpassword', 
        ['as' => 'customer.setmypassword', 'uses' => 'CustomerController@setCustomerPassword']
    );

    Route::put(
        '/{customer_id}', 
        ['as' => 'customer.putbyid', 'uses' => 'CustomerController@setCustomer']
    );

    Route::put(
        '/{customer_id}/activate', 
        ['as' => 'customer.activate', 'uses' => 'CustomerController@setCustomer']
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
        '/{customer_id}/addresses/add', 
        ['as' => 'customer.add.address', 'uses' => 'CustomerController@addCustomerAddress']
    );

    Route::put(
        '/{customer_id}/default_billing_address/{address_id}', 
        ['as' => 'customer.put.mydefault_billing_address', 'uses' => 'CustomerController@setDefaultBillingAddress']
    );

    Route::put(
        '/{customer_id}/default_shipping_address/{address_id}', 
        ['as' => 'customer.put.mydefault_shipping_address', 'uses' => 'CustomerController@setDefaultShippingAddress']
    );

    Route::post(
        '/{customer_id}/addresses/add', 
        ['as' => 'customer.me.add.address', 'uses' => 'CustomerController@addAddress']
    );
});