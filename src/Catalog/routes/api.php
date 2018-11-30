<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        // 'middleware' => ['web']
        // 'middleware' => ['cors', 'auth:api']
        'middleware' => ['cors']
    ], function () {
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
            '/product/{id}', 
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