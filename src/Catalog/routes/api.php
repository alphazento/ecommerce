<?php
//front-end
Route::group(
    [
        'prefix' => '/api/v1/catalog',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
    ], function () {
        Route::get(
            '/categories/tree', 
            ['as' => 'get.categories.tree', 'uses' => 'CategoryController@categoriesTree']
        );

        Route::get(
            '/categories/{ids}/',
            ['as' => 'category', 'uses' => 'CategoryController@categories']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/{id}/products',
            ['as' => 'category.products', 'uses' => 'CategoryController@productsOfCategory']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'product', 'uses' => 'ProductController@product']
        );
    }
);

//admin
Route::group(
    [
        'prefix' => '/api/v1/admin/catalog',
        'namespace' => '\Zento\Catalog\Http\Controllers\Api',
        'middleware' => ['backend']
    ], function () {
        Route::get(
            '/categories', 
            ['as' => 'admin.get.categories', 'uses' => 'CategoryController@categories']
        );
        
        Route::get(
            '/categories/{ids}/',
            ['as' => 'admin.get.category', 'uses' => 'CategoryController@categories']
        )->where('ids', '([\d\/]+)?');

        Route::get(
            '/categories/tree', 
            ['as' => 'admin.get.categories.tree', 'uses' => 'CategoryController@categoriesTree']
        );

        Route::get(
            '/categories/{id}/products',
            ['as' => 'admin.category.products', 'uses' => 'CategoryController@productsOfCategory']
        );

        Route::get(
            '/categories/{id}/values', 
            ['as' => 'category.values', 'uses' => 'CategoryController@categoryValues']
        );

        Route::get(
            '/categories/{id}/values/Catalog/Category', 
            ['as' => 'category.values', 'uses' => 'CategoryController@categoryValues']
        );

        Route::post(
            '/categories', 
            ['as' => 'post.category', 'uses' => 'CategoryController@newCategory']
        );
        
        Route::patch(
            '/categories/{id}/{attribute}', 
            ['as' => 'category.put.attribute', 'uses' => 'CategoryController@setAttribute']
        );

        Route::get(
            '/products/{id}', 
            ['as' => 'admin.get.product', 'uses' => 'ProductController@product']
        );

        Route::post(
            '/products', 
            ['as' => 'post.products', 'uses' => 'ProductController@create']
        );
        
        Route::patch(
            '/products/{id}/{attribute}', 
            ['as' => 'products.put.attribute', 'uses' => 'ProductController@setAttribute']
        );
    }
);