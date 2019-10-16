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