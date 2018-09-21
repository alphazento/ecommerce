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
        '/home', 
        ['uses' => 'CatalogController@home']
    );

    Route::get(
        '/category/{id}', 
        ['as' => 'catalog.category', 'uses' => 'CatalogController@category']
    );
    Route::get(
        '/product/{id}', 
        ['as' => 'catalog.product', 'uses' => 'CatalogController@product']
    );
    Route::get(
        '/product_popup_image/{id}', 
        ['as' => 'catalog.product', 'uses' => 'CatalogController@product_popup_image']
    );
    
    Route::get(
        '/series/{id}', 
        ['as' => 'catalog.series', 'uses' => 'CatalogController@series']
    );
    Route::get(
        '/search',
        ['as' => 'catalog.search', 'uses' => 'CatalogController@search']
    );

    Route::get(
        '/brands/{brandId}/printer-series',
        ['as' => 'catalog.brand.printer-series', 'uses' => 'CatalogController@findPrinterSeries']
    );

    Route::get(
        '/brands/printer-series/printer-models',
        ['as' => 'catalog.brand.printer-models', 'uses' => 'CatalogController@findPrinterModels']
    );


    Route::get(
        '/printer/redirect',
        ['as' => 'catalog.brand.printer-redirect', 'uses' => 'CatalogController@printerRedirect']
    );

    Route::get(
        '/search/redirect',
        ['as' => 'catalog.legacy.search', 'uses' => 'CatalogController@redirectSearch']
    );
});