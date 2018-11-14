<?php
Route::group(
    [
        'prefix' => '/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'cart.index', 'uses' => 'ShoppingCartController@index']
    );

    Route::post(
        '/items/add',
        ['as' => 'cart.add', 'uses' => 'ShoppingCartController@addProduct']
    );

    Route::post(
        '/items/{item_id}/delete', 
        ['as' => 'cart.item.delete', 'uses' => 'ShoppingCartController@deleteItem']
    );

    Route::post(
        '/items/{item_id}/update/quantity/{quantity}', 
        ['as' => 'cart.item.update.quantity', 'uses' => 'ShoppingCartController@updateItemQuantity']
    );

    Route::get(
        '/billing_address', 
        ['as' => 'cart.billing_address', 'uses' => 'ShoppingCartController@index']
    );

    Route::post(
        '/billing_address', 
        ['as' => 'cart.billing_address.post', 'uses' => 'ShoppingCartController@index']
    );

    Route::get(
        '/shipping_address', 
        ['as' => 'cart.shipping_address', 'uses' => 'ShoppingCartController@index']
    );

    Route::post(
        '/shipping_address', 
        ['as' => 'cart.shipping_address.post', 'uses' => 'ShoppingCartController@index']
    );
    
    // Route::get(
    //     '/category/{ids}/',
    //     ['as' => 'category', 'uses' => 'CatalogController@category']
    // )->where('ids', '([\d\/]+)?');
});

Route::group(
    [
        'prefix' => '/rest/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors', 'auth:api']
    ], function () {
        $apiRoutes = [
            'cart.create' => [ 'post', '/create', 'ShoppingCartController@createCart'],
            'cart.getone' => [ 'get', '/{cart_guid}', 'ShoppingCartController@getCart'],
            'cart.delete' => [ 'delete', '/{cart_guid}', 'ShoppingCartController@deleteCart'],
            'cart.add.item' => [ 'post', '/{cart_guid}/items/add', 'ShoppingCartController@addItem'],
            'cart.delete.item' => [ 'delete', '/{cart_guid}/items/{item_id}', 'ShoppingCartController@deleteItem'],
            'cart.patch.item.quantity' => [ 'patch', '/{cart_guid}/items/{item_id}/quantity/{quantity}', 'ShoppingCartController@updateItemQuantity'],
            'cart.get.coupons' => [ 'get', '/{cart_guid}/coupons', 'ShoppingCartController@getCoupons'],
            'cart.delete.coupons' => [ 'delete', '/{cart_guid}/coupons', 'ShoppingCartController@deleteCoupons'],
            'cart.put.coupon' => [ 'put', '/{cart_guid}/coupons/{coupon_code}', 'ShoppingCartController@putCoupon'],
            'cart.get.billing_address' => [ 'get', '/{cart_guid}/billing_address', 'ShoppingCartController@getBillingAddress'],
            'cart.put.billing_address' => [ 'put', '/{cart_guid}/billing_address', 'ShoppingCartController@setBillingAddress'],
            'cart.get.shopping_address' => [ 'get', '/{cart_guid}/shopping_address', 'ShoppingCartController@getShoppingAddress'],
            'cart.put.shopping_address' => [ 'put', '/{cart_guid}/shopping_address', 'ShoppingCartController@setShoppingAddress'],
            'cart.merge' => [ 'post', '/{cart_guid}/to/{to_cart_guid}', 'ShoppingCartController@mergeCart'],
            'cart.get.customer' => [ 'get', '/{cart_guid}/customer', 'ShoppingCartController@getCustomer'],
            'cart.put.customer' => [ 'put', '/{cart_guid}/customer/{customer_id}', 'ShoppingCartController@setCustomer'],
        ];
        foreach($apiRoutes as $name => $route) {
            Route::{$route[0]}(
                $route[1],
                ['as' => $name, 'uses' => $route[2]]
            );
        }
});