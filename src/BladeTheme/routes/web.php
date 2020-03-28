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
        ['as' =>'home', 'uses' => 'GeneralController@home']
    );

    Route::get(
        'home', 
        ['as' =>'home', 'uses' => 'GeneralController@home']
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
        Route::get('categories/{id}', 'CatalogController@categoryProducts');
        Route::get('products/{id}', 'CatalogController@product');
        Route::get('products/{id}/categories/{category_ids}', 'CatalogController@product');
        Route::get('search', 'CatalogController@search');
    });

Route::group(
    [
        'prefix' => '/shoppingcart',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', 'ShoppingCartController@index');
        Route::post('/products/{pid}', 'ShoppingCartController@addItem');
    }
);

Route::group(
    [
        'prefix' => '/{protocal}/shoppingcart',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', 'ShoppingCartController@index');
        Route::post('/products/{pid}', 'ShoppingCartController@addItem');
        Route::delete('/items/{item_id}', 'ShoppingCartController@deleteItem');
        Route::put('/items/{pid}/qty/{qty}', 'ShoppingCartController@updateItemQty');
    }
);

Route::group(
    [
        'prefix' => '/checkout',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', 'CheckoutController@index');
        Route::get('/success', 'CheckoutController@success');
    }
);

Route::group(
    [
        'prefix' => '/ajax/checkout',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::put('/guest/details', 'ApiController@putGuestDetails');
    }
);


Route::group(
    [
        'prefix' => '/ajax/sales',
        'namespace' => '\Zento\Sales\Http\Controllers\Api',
        'middleware' => ['web'],
    ], function () {
        Route::post(
            '/orders', 'SalesController@createOrder');
    }
);
