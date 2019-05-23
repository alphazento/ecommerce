<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/categories', 
            ['as' => 'get.categories', 'uses' => 'CatalogController@categories']
        );
        
        Route::get(
            '/categories/tree', 
            ['as' => 'get.categories.tree', 'uses' => 'CatalogController@categoriesTree']
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
        'prefix' => '/api/v1/admin',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/categories', 
            ['as' => 'admin.get.categories', 'uses' => 'CatalogController@categories']
        );
        
        Route::get(
            '/categories/tree', 
            ['as' => 'admin.get.categories.tree', 'uses' => 'CatalogController@categoriesTree']
        );

        Route::get(
            '/categories/{ids}/',
            ['as' => 'admin.get.category', 'uses' => 'CatalogController@category']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/{id}/products',
            ['as' => 'admin.category.products', 'uses' => 'CatalogController@productsOfCategory']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'admin.get.product', 'uses' => 'CatalogController@product']
        );

        Route::get(
            '/catalog/categories/{id}/values', 
            ['as' => 'category.values', 'uses' => 'CatalogController@categoryValues']
        );

        Route::get(
            '/catalog/categories/{id}/values/Catalog/Category', 
            ['as' => 'category.values', 'uses' => 'CatalogController@categoryValues']
        );

        Route::put(
            '/catalog/categories/{id}/{field}', 
            ['as' => 'category.put.filed', 'uses' => 'CatalogController@setCategoryField']
        );
});