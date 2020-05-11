<?php
Route::group(
    [
        'prefix' => '/api/v1/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors', 'auth:api'],
    ], function () {
        Route::get(
            '/me', 'CustomerController@me'
        );

        Route::patch(
            '/me',
            'CustomerController@update'
        );

        Route::patch(
            '/me/password', 'CustomerController@setPassword'
        );

        Route::get(
            '/me/addresses', 'CustomerController@getAddresses'
        );

        Route::get(
            '/me/address/{address_id}', 'CustomerController@getAddress'
        );

        Route::post(
            '/me/addresses/', 'CustomerController@addAddress'
        );

        Route::patch('/me/default_billing_address/{address_id}',
            'CustomerController@setDefaultBillingAddress');

        Route::patch(
            '/me/default_shipping_address/{address_id}',
            'CustomerController@setDefaultShippingAddress'
        );
    });

Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors'],
    ], function () {
        Route::get(
            '/countries',
            ['as' => 'api.getcountries', 'uses' => 'AddressController@countryAndStates']
        );
    });

//admin
Route::group(
    [
        'prefix' => '/api/v1/admin/customers',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['cors', 'backend', 'auth:api'],
    ], function () {
        //admin only
        // Route::put(
        //     '/{customer_id}/status/{active}',
        //     ['as' => 'customer.activate', 'uses' => 'CustomerController@activateCustomer']
        // );

        // Route::delete(
        //     '/{customer_id}/addresses/{id}',
        //     ['as' => 'customer.add.address', 'uses' => 'CustomerController@addCustomerAddress']
        // );
    });
