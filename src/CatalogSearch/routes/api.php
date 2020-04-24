<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\CatalogSearch\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::get(
            '/catalog/search', 
            ['as' => 'catalog.search', 'uses' => 'CatalogSearchController@search']
        );
        Route::get(
            '/catalog/search/categories/{id}', 
            ['as' => 'catalog.category.search', 'uses' => 'CatalogSearchController@search']
        );
});

//admin
Route::group(
    [
        'prefix' => '/api/v1/admin',
        'namespace' => '\Zento\CatalogSearch\Http\Controllers\Api',
        'middleware' => ['cors', 'backend'],
    ], function () {
        Route::get(
            '/catalog/search', 
            ['as' => 'admin.get.products', 'uses' => 'CatalogSearchController@adminSearch']
        );
});