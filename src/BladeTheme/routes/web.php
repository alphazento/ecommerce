<?php
/**
 * general route for a website
 */
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get(
            '/',
            ['as' => 'home', 'uses' => 'GeneralController@home']
        );

        Route::get('home', 'GeneralController@home');

        Route::get(
            'about-us',
            ['as' => 'aboutus.page', 'uses' => 'GeneralController@aboutUs']
        );

        Route::get(
            'contact-us',
            ['as' => 'contactus.page', 'uses' => 'GeneralController@contactUs']
        );
        Route::get(
            'news',
            ['as' => 'news.page', 'uses' => 'GeneralController@news']
        );
        Route::get(
            'privacy',
            ['as' => 'privacy.page', 'uses' => 'GeneralController@privacy']
        );
        Route::get(
            'terms-conditions',
            ['as' => 'terms.page', 'uses' => 'GeneralController@terms']
        );
    });

/**
 * catalog pages
 */
Route::group(
    [
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/categories/{id}', 'CatalogController@categoryProducts');
        Route::get('/products/{id}', 'CatalogController@product');
        Route::get('/products/{id}/categories/{category_ids}', 'CatalogController@product');
        Route::get('/search', 'CatalogController@search');
    }
);

/**
 * shopping cart
 */
Route::group(
    [
        'prefix' => '/shoppingcart',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', ['as' => 'cart.page', 'uses' => 'ShoppingCartController@index']);
        Route::post('/products/{pid}', 'ShoppingCartController@addItem');
    }
);

/**
 * web checkout pages
 */
Route::group(
    [
        'prefix' => '/checkout',
        'namespace' => '\Zento\BladeTheme\Http\Controllers',
        'middleware' => ['web'],
    ], function () {
        Route::get('/', ['as' => 'checkout.page', 'uses' => 'CheckoutController@index']);
        Route::get('/success', 'CheckoutController@success');
    }
);

/**
 * ajax checkout support pages
 */
Route::group(
    [
        'prefix' => '/ajax',
        'middleware' => ['web'],
    ], function () {
        Route::put('/checkout/guest/details',
            '\Zento\Checkout\Http\Controllers\ApiController@storeGuestDetails');
        Route::post('/sales/orders',
            '\Zento\Sales\Http\Controllers\Api\SalesController@createOrder');
    }
);
