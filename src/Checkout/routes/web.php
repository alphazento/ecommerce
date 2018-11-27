<?php
Route::group(
    [
        'prefix' => '/checkout',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get(
        '/', 
        ['as' => 'checkout.index', 'uses' => 'CheckoutController@index']
    );

    // Route::get(
    //     '/category/{ids}/',
    //     ['as' => 'category', 'uses' => 'CatalogController@category']
    // )->where('ids', '([\d\/]+)?');
});