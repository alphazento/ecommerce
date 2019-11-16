<?php

//general route for a website
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' =>'web.get.home', 'uses' => 'GeneralController@home']
    );

    Route::get(
        'about-us', 
        ['as' =>'web.get.aboutus', 'uses' => 'GeneralController@aboutUs']
    );
    Route::get(
        'contact-us', 
        ['as' =>'web.get.contactus', 'uses' => 'GeneralController@contactUs']
    );
    Route::get(
        'news', 
        ['as' =>'web.get.news', 'uses' => 'GeneralController@news']
    );
    Route::get(
        'privacy', 
        ['as' =>'web.get.privacy', 'uses' => 'GeneralController@privacy']
    );
    Route::get(
        'terms-conditions', 
        ['as' =>'web.get.terms', 'uses' => 'GeneralController@terms']
    );
});

Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
        Route::get(
            'categories/{id}', 
            ['as' =>'web.get.category.products', 'uses' => 'CatalogController@category']
        );
    
        Route::get(
            'products/{id}', 
            ['as' =>'web.get.product', 'uses' => 'CatalogController@product']
        );

        Route::get(
            'products/{id}/categories/{category_ids}', 
            ['as' =>'web.get.product', 'uses' => 'CatalogController@product']
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
        'prefix' => '/{protocal}/shoppingcart',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', [
            'as' =>'ajax.get.cart', 'uses' => 'ShoppingCartController@cartPage'
        ]);

        Route::post('/add_product/{pid}', [
            'as' => 'ajax.post.cart.add.product', 'uses' => 'ShoppingCartController@addItem'
        ]);

        Route::post('/delete_item/{item_id}', [
            'as' => 'ajax.post.cart.delete.item', 'uses' => 'ShoppingCartController@deleteItem'
        ]);

        Route::post('/update_item_qty/{pid}', [
            'as' => 'ajax.post.cart.update.itemqty', 'uses' => 'ShoppingCartController@deleteItemQty'
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
            'as' =>'web.get.checkout', 'uses' => 'CheckoutController@index'
        ]);

        Route::post('/checkout/process', [
            'as' => 'web.post.checkout.process', 'uses' => 'CheckoutController@process'
        ]);

        Route::post('/checkout/success', [
            'as' => 'web.post.cart.add.product', 'uses' => 'CheckoutController@success'
        ]);
    }
);