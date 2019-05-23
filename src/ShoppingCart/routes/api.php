<?php
$apiRoutes = [
    'cart.create' => [ 'method' => 'post', 'path' => '/', 'uses' => 'ShoppingCartController@createCart', 'allow_guest' => true],
    'cart.getone' => [ 'method' => 'get', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@getCart', 'allow_guest' => true],
    'cart.delete' => [ 'method' => 'delete', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@deleteCart', 'allow_guest' => true],
    'cart.add.item' => [ 'method' => 'post', 'path' =>'/{cart_guid}/items', 'uses' => 'ShoppingCartController@addItem', 'allow_guest' => true],
    'cart.update.email' => [ 'method' => 'post', 'path' =>'/{cart_guid}/email/', 'uses' => 'ShoppingCartController@updateEmail', 'allow_guest' => true],
    'cart.delete.item' => [ 'method' => 'delete', 'path' =>'/{cart_guid}/items/{item_id}', 'uses' => 'ShoppingCartController@deleteItem', 'allow_guest' => true],
    'cart.patch.item.quantity' => [ 'method' => 'patch', 'path' => '/{cart_guid}/items/{item_id}/quantity/{quantity}', 'uses' => 'ShoppingCartController@updateItemQuantity', 'allow_guest' => true],
    'cart.get.coupon' => [ 'method' => 'get', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@getCoupon', 'allow_guest' => true],
    'cart.delete.coupon' => [ 'method' => 'delete', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@deleteCoupon', 'allow_guest' => true],
    'cart.put.coupon' => [ 'method' => 'put', 'path' => '/{cart_guid}/coupon/{coupon_code}', 'uses' => 'ShoppingCartController@putCoupon', 'allow_guest' => true],
    'cart.get.billing_address' => [ 'method' => 'get', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@getBillingAddress', 'allow_guest' => true],
    'cart.put.billing_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@setBillingAddress', 'allow_guest' => true],
    'cart.get.shopping_address' => [ 'method' => 'get', 'path' => '/{cart_guid}/shopping_address', 'uses' => 'ShoppingCartController@getShoppingAddress', 'allow_guest' => true],
    'cart.put.shopping_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/shopping_address', 'uses' =>  'ShoppingCartController@setShoppingAddress', 'allow_guest' => true],
    'cart.merge' => [ 'method' => 'post', 'path' => '/{cart_guid}/to/{to_cart_guid}', 'uses' => 'ShoppingCartController@mergeCart', 'allow_guest' => false],
    'cart.get.customer' => [ 'method' => 'get', 'path' => '/{cart_guid}/customer', 'uses' => 'ShoppingCartController@getCustomer', 'allow_guest' => false],
    'cart.put.customer' => [ 'method' => 'put', 'path' => '/{cart_guid}/customer/{customer_id}', 'uses' => 'ShoppingCartController@setCustomer', 'allow_guest' => false],
];

Route::group(
    [
        'prefix' => '/api/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['setuppassport', 'auth:api'],
        'as' => 'cart:frontend:'
    ], function () use ($apiRoutes) {
        foreach($apiRoutes as $name => $route) {
            Route::{$route['method']}(
                $route['path'],
                ['as' => $name, 'uses' => $route['uses']]
            );
        }
});