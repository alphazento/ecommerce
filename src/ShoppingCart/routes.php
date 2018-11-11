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
        'namespace' => '\Zento\ShoppingCart\Http\Controllers',
        'middleware' => ['cors']
        // 'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'cart.index', 'uses' => 'ShoppingCartApiController@index']
    );

    Route::post(
        '/items/add', 
        ['as' => 'cart.add', 'uses' => 'ShoppingCartApiController@addProduct']
    );

    Route::post(
        '/items/{item_id}/delete', 
        ['as' => 'cart.item.delete', 'uses' => 'ShoppingCartApiController@deleteItem']
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
});