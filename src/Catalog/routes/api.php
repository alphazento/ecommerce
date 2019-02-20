<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        // 'middleware' => ['web']
        // 'middleware' => ['cors', 'auth:api']
        'middleware' => ['cors']
    ], function () {
        Route::post(
            '/catalog/search', 
            ['as' => 'home', 'uses' => 'CatalogController@search']
        );

        Route::get(
            '/categories', 
            ['as' => 'home', 'uses' => 'CatalogController@categories']
        );
        
        Route::get(
            '/categories/tree', 
            ['as' => 'home', 'uses' => 'CatalogController@categoriesTree']
        );

        Route::get(
            '/categories/{ids}/',
            ['as' => 'category', 'uses' => 'CatalogController@category']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/{id}/products',
            ['as' => 'category.products', 'uses' => 'CatalogController@productsOfCategory']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'product', 'uses' => 'CatalogController@product']
        );

        Route::get(
            '/section/newproducts', 
            ['as' => 'section.newproducts', 'uses' => 'CatalogController@newProductSection']
        );

        Route::get(
            '/section/shoppingcollection', 
            ['as' => 'section.shoppingcollection', 'uses' => 'CatalogController@shoppingCollectionSection']
        );
});

//admin
Route::group(
    [
        'prefix' => '/admin/rest/v1',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () {
        Route::post(
            '/catalog/search',
            ['as' => 'home', 'uses' => 'CatalogController@search']
        );

        Route::get(
            '/categories', 
            ['as' => 'home', 'uses' => 'CatalogController@categories']
        );
        
        Route::get(
            '/categories/tree', 
            ['as' => 'home', 'uses' => 'CatalogController@categoriesTree']
        );

        Route::get(
            '/categories/{ids}/',
            ['as' => 'category', 'uses' => 'CatalogController@category']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/{id}/products',
            ['as' => 'category.products', 'uses' => 'CatalogController@productsOfCategory']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'product', 'uses' => 'CatalogController@product']
        );

        Route::post(
            '/catalog/categories/{id}/values', 
            ['as' => 'category.values', 'uses' => 'CatalogController@categoryValues']
        );
});