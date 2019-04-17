<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\CatalogSearch\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () {
        Route::post(
            '/catalog/search', 
            ['as' => 'catalog.search', 'uses' => 'CatalogSearchController@search']
        );
        Route::get(
            '/catalog/search', 
            ['as' => 'catalog.search', 'uses' => 'CatalogSearchController@search']
        );
});

//admin
Route::group(
    [
        'prefix' => '/rest/v1/admin',
        'namespace' => '\Zento\CatalogSearch\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/catalog/search', 
            ['as' => 'admin.get.products', 'uses' => 'CatalogSearchController@adminSearch']
        );
        Route::post(
            '/catalog/search', 
            ['as' => 'admin.get.products', 'uses' => 'CatalogSearchController@adminSearch']
        );
});