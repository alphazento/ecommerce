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
        'middleware' => ['cors']
        // 'middleware' => ['web']
    ], function () {
    Route::get(
        '/{guid}', 
        ['as' => 'cart.get', 'uses' => 'ShoppingCartController@getCart']
    );

    Route::post(
        '/new', 
        ['as' => 'cart.new', 'uses' => 'ShoppingCartController@newCart']
    );

    Route::delete(
        '/{guid}', 
        ['as' => 'cart.delete', 'uses' => 'ShoppingCartController@deleteCart']
    );

    Route::post(
        '/{guid}/items/add', 
        ['as' => 'cart.add', 'uses' => 'ShoppingCartController@addProduct']
    );

    Route::delete(
        '/{guid}/items/{item_id}/delete', 
        ['as' => 'cart.item.delete', 'uses' => 'ShoppingCartController@deleteItem']
    );

    Route::post(
        '/{guid}/items/{item_id}/update/quantity/{quantity}', 
        ['as' => 'cart.item.update.quantity', 'uses' => 'ShoppingCartController@updateItemQuantity']
    );

    Route::get(
        '/{guid}/billing_address', 
        ['as' => 'cart.billing_address', 'uses' => 'ShoppingCartController@index']
    );

    Route::post(
        '/{guid}/billing_address', 
        ['as' => 'cart.billing_address.post', 'uses' => 'ShoppingCartController@index']
    );

    Route::get(
        '/{guid}/shipping_address', 
        ['as' => 'cart.shipping_address', 'uses' => 'ShoppingCartController@index']
    );

    Route::post(
        '/{guid}/shipping_address', 
        ['as' => 'cart.shipping_address.post', 'uses' => 'ShoppingCartController@index']
    );
});