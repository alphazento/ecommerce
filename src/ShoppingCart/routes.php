<?php
Route::group(
    [
        'prefix' => '/shopping_cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'shopping_cart.index', 'uses' => 'ShoppingCartController@index']
    );

    // Route::get(
    //     '/category/{ids}/',
    //     ['as' => 'category', 'uses' => 'CatalogController@category']
    // )->where('ids', '([\d\/]+)?');
});