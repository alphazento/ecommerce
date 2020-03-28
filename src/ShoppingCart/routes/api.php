<?php

Route::group(
    [
        'prefix' => '/api/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
    ], function () {
        Route::get('/', 'ShoppingCartController@getCart');
        Route::post('/', 'ShoppingCartController@create');
        Route::delete('/', 'ShoppingCartController@delete');
        Route::post('/items', 'ShoppingCartController@addItem');
        Route::post('/items/{item_id}', 'ShoppingCartController@deleteItem');
        Route::post('/items/{item_id}/quantity/{quantity}', 'ShoppingCartController@updateItemQuantity');

        Route::post('/email', 'ShoppingCartController@updateEmail');
        Route::get('/coupon', 'ShoppingCartController@getCoupon');
        Route::delete('/coupon', 'ShoppingCartController@deleteCoupon');
        Route::put('/coupon', 'ShoppingCartController@putCoupon');
        Route::put('/billing_address', 'ShoppingCartController@setBillingAddress');
        Route::put('/shipping_address', 'ShoppingCartController@setShippingAddress');
        Route::post('/to/{to_cart_guid}', 'ShoppingCartController@mergeCart');
        Route::get('/customer', 'ShoppingCartController@getCustomer');
        Route::put('/customer', 'ShoppingCartController@setCustomer');
});