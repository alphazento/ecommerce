<?php
Route::group(
    [
        'prefix' => '/shoppingcart',
        'namespace' => '\Zento\WebShoppingCart\Http\Controllers\Web',
        'middleware' => ['web'],
    ], function () {
        Route::get(
            '/', 
            ['as' =>'web.get.cart', 'uses' => 'ShoppingCartController@cartPage']
        );

        Route::post('/add-item/{pid}', [
            'as' => 'web.post.cart.add.item', 'uses' => 'ShoppingCartController@addItem'
        ]);

        Route::post('/delete-item/{pid}', [
            'as' => 'web.post.cart.delete.item', 'uses' => 'ShoppingCartController@deleteItem'
        ]);

        Route::post('/update-item-qty/{pid}', [
            'as' => 'web.post.cart.update.itemqty', 'uses' => 'ShoppingCartController@deleteItemQty'
        ]);
    }
);