<?php
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        'categories/{id}', 
        ['as' =>'web.get.category.products', 'uses' => 'CatalogController@categories']
    );

    Route::get(
        'products/{id}', 
        ['as' =>'web.get.product', 'uses' => 'CatalogController@product']
    );

    Route::get(
        'products', 
        ['as' =>'web.get.products', 'uses' => 'CatalogController@products']
    );
});

Route::group(
    [
        'prefix' => '/shoppingcart',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', [
            'as' =>'web.get.cart', 'uses' => 'ShoppingCartController@cartPage'
        ]);

        Route::post('/add_product/{pid}', [
            'as' => 'web.post.cart.add.product', 'uses' => 'ShoppingCartController@addItem'
        ]);

        Route::post('/delete_item/{item_id}', [
            'as' => 'web.post.cart.delete.item', 'uses' => 'ShoppingCartController@deleteItem'
        ]);

        Route::post('/update_item_qty/{pid}', [
            'as' => 'web.post.cart.update.itemqty', 'uses' => 'ShoppingCartController@deleteItemQty'
        ]);
    }
);

Route::group(
    [
        'prefix' => '/checkout',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', [
            'as' =>'web.get.checkout', 'uses' => 'CheckoutController@page'
        ]);

        Route::post('/checkout/process', [
            'as' => 'web.post.checkout.process', 'uses' => 'CheckoutController@process'
        ]);

        Route::post('/checkout/success', [
            'as' => 'web.post.cart.add.product', 'uses' => 'CheckoutController@success'
        ]);
    }
);