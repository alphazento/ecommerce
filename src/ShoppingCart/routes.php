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

$apiRoutes = [
    'cart.create' => [ 'method' => 'post', 'path' => '/create', 'uses' => 'ShoppingCartController@createCart', 'allow_guest' => true],
    'cart.getone' => [ 'method' => 'get', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@getCart', 'allow_guest' => true],
    'cart.delete' => [ 'method' => 'delete', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@deleteCart', 'allow_guest' => true],
    'cart.add.item' => [ 'method' => 'post', 'path' =>'/{cart_guid}/items/add', 'uses' => 'ShoppingCartController@addItem', 'allow_guest' => true],
    'cart.delete.item' => [ 'method' => 'delete', 'path' =>'/{cart_guid}/items/{item_id}', 'uses' => 'ShoppingCartController@deleteItem', 'allow_guest' => true],
    'cart.patch.item.quantity' => [ 'method' => 'patch', 'path' => '/{cart_guid}/items/{item_id}/quantity/{quantity}', 'uses' => 'ShoppingCartController@updateItemQuantity', 'allow_guest' => true],
    'cart.get.coupons' => [ 'method' => 'get', 'path' => '/{cart_guid}/coupons', 'uses' => 'ShoppingCartController@getCoupons', 'allow_guest' => true],
    'cart.delete.coupons' => [ 'method' => 'delete', 'path' => '/{cart_guid}/coupons', 'uses' => 'ShoppingCartController@deleteCoupons', 'allow_guest' => true],
    'cart.put.coupon' => [ 'method' => 'put', 'path' => '/{cart_guid}/coupons/{coupon_code}', 'uses' => 'ShoppingCartController@putCoupon', 'allow_guest' => true],
    'cart.get.billing_address' => [ 'method' => 'get', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@getBillingAddress', 'allow_guest' => true],
    'cart.put.billing_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@setBillingAddress', 'allow_guest' => true],
    'cart.get.shopping_address' => [ 'method' => 'get', 'path' => '/{cart_guid}/shopping_address', 'uses' => 'ShoppingCartController@getShoppingAddress', 'allow_guest' => true],
    'cart.put.shopping_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/shopping_address', 'uses' =>  'ShoppingCartController@setShoppingAddress', 'allow_guest' => true],
    'cart.merge' => [ 'method' => 'post', 'path' => '/{cart_guid}/to/{to_cart_guid}', 'uses' => 'ShoppingCartController@mergeCart', 'allow_guest' => false],
    'cart.get.customer' => [ 'method' => 'get', 'path' => '/{cart_guid}/customer', 'uses' => 'ShoppingCartController@getCustomer', 'allow_guest' => false],
    'cart.put.customer' => [ 'method' => 'put', 'path' => '/{cart_guid}/customer/{customer_id}', 'uses' => 'ShoppingCartController@setCustomer', 'allow_guest' => false],
];

Route::group(
    [
        'prefix' => '/rest/v1/guest-cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () use ($apiRoutes) {
        foreach($apiRoutes as $name => $route) {
            if ($route['allow_guest'] ?? false) {
                Route::{$route['method']}(
                    $route['path'],
                    ['as' => $name, 'uses' => $route['uses']]
                );
            }
        }
});

Route::group(
    [
        'prefix' => '/rest/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['authapi']
    ], function () use ($apiRoutes) {
        foreach($apiRoutes as $name => $route) {
            Route::{$route['method']}(
                $route['path'],
                ['as' => $name, 'uses' => $route['uses']]
            );
        }
});


Route::group(
    [
        'prefix' => '/rest/v1/test',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () use ($apiRoutes) {
        Route::post(
            '/urlrewrite',
            ['uses' => 'TestController@getUrlRewrite']
        );
});