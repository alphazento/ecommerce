<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::get(
            '/categories/tree', 
            ['as' => 'get.categories.tree', 'uses' => 'CatalogController@categoriesTree']
        );

        Route::get(
            '/categories/{ids}/',
            ['as' => 'category', 'uses' => 'CatalogController@categories']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/{id}/products',
            ['as' => 'category.products', 'uses' => 'CatalogController@productsOfCategory']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'product', 'uses' => 'CatalogController@product']
        );
});

//admin
Route::group(
    [
        'prefix' => '/api/v1/admin',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['backend']
    ], function () {
        Route::get(
            '/categories', 
            ['as' => 'admin.get.categories', 'uses' => 'CatalogController@categories']
        );
        
        Route::get(
            '/categories/{ids}/',
            ['as' => 'admin.get.category', 'uses' => 'CatalogController@categories']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/tree', 
            ['as' => 'admin.get.categories.tree', 'uses' => 'CatalogController@categoriesTree']
        );

        Route::get(
            '/categories/{id}/products',
            ['as' => 'admin.category.products', 'uses' => 'CatalogController@productsOfCategory']
        );

        Route::get(
            '/products', 
            ['as' => 'admin.get.products', 'uses' => 'CatalogController@products']
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

        Route::post(
            '/catalog/categories', 
            ['as' => 'post.category', 'uses' => 'CatalogController@newCategory']
        );
        
        Route::patch(
            '/catalog/categories/{id}/{field}', 
            ['as' => 'category.put.filed', 'uses' => 'CatalogController@setCategoryField']
        );
});