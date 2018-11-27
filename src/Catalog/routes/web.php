<?php
Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\Catalog\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'home', 'uses' => 'CatalogController@home']
    );

    Route::get(
        '/product/{id}', 
        ['as' => 'product', 'uses' => 'CatalogController@product']
    );
    // Route::get(
    //     '/home', 
    //     ['uses' => 'CatalogController@home']
    // );

    // Route::get(
    //     '/category/{id}', 
    //     ['as' => 'catalog.category', 'uses' => 'CatalogController@category']
    // );
    // Route::get(
    //     '/product/{id}', 
    //     ['as' => 'catalog.product', 'uses' => 'CatalogController@product']
    // );
    // Route::get(
    //     '/product_popup_image/{id}', 
    //     ['as' => 'catalog.product', 'uses' => 'CatalogController@product_popup_image']
    // );
    
    // Route::get(
    //     '/series/{id}', 
    //     ['as' => 'catalog.series', 'uses' => 'CatalogController@series']
    // );
    // Route::get(
    //     '/search',
    //     ['as' => 'catalog.search', 'uses' => 'CatalogController@search']
    // );

    // Route::get(
    //     '/brands/{brandId}/printer-series',
    //     ['as' => 'catalog.brand.printer-series', 'uses' => 'CatalogController@findPrinterSeries']
    // );

    // Route::get(
    //     '/brands/printer-series/printer-models',
    //     ['as' => 'catalog.brand.printer-models', 'uses' => 'CatalogController@findPrinterModels']
    // );


    // Route::get(
    //     '/printer/redirect',
    //     ['as' => 'catalog.brand.printer-redirect', 'uses' => 'CatalogController@printerRedirect']
    // );

    // Route::get(
    //     '/search/redirect',
    //     ['as' => 'catalog.legacy.search', 'uses' => 'CatalogController@redirectSearch']
    // );

    Route::get(
        '/contact',
        ['as' => 'contact', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/account',
        ['as' => 'account', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/order',
        ['as' => 'order', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/transaction',
        ['as' => 'transaction', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/download',
        ['as' => 'download', 'uses' => 'CatalogController@home']
    );
    // Route::get(
    //     '/logout',
    //     ['as' => 'logout', 'uses' => 'CatalogController@home']
    // );
    // Route::get(
    //     '/register',
    //     ['as' => 'register', 'uses' => 'CatalogController@home']
    // );

    // Route::get(
    //     '/login',
    //     ['as' => 'login', 'uses' => 'CatalogController@home']
    // );
    Route::get(
        '/wishlist',
        ['as' => 'wishlist', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/shopping_cart',
        ['as' => 'shopping_cart', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/checkout',
        ['as' => 'checkout', 'uses' => 'CatalogController@home']
    );

    Route::get(
        '/return',
        ['as' => 'return', 'uses' => 'CatalogController@home']
    );

    Route::get(
        '/sitemap',
        ['as' => 'sitemap', 'uses' => 'CatalogController@home']
    );

    Route::get(
        '/manufacturer',
        ['as' => 'manufacturer', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/voucher',
        ['as' => 'voucher', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/affiliate',
        ['as' => 'affiliate', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/special',
        ['as' => 'special', 'uses' => 'CatalogController@home']
    );
    Route::get(
        '/newsletter',
        ['as' => 'newsletter', 'uses' => 'CatalogController@home']
    );

    Route::get(
        '/category/{ids}/',
        ['as' => 'category', 'uses' => 'CatalogController@category']
    )->where('ids', '([\d\/]+)?');
});