<?php
$apiRoutes = [
    'create' => [ 'method' => 'post', 'path' => '/', 'uses' => 'ShoppingCartController@createCart'],
    'get' => [ 'method' => 'get', 'path' =>'/', 'uses' => 'ShoppingCartController@getCart'],
    'delete' => [ 'method' => 'delete', 'path' =>'/', 'uses' => 'ShoppingCartController@deleteCart'],
    'add.item' => [ 'method' => 'post', 'path' =>'/items', 'uses' => 'ShoppingCartController@addItem'],
    'update.email' => [ 'method' => 'post', 'path' =>'/email/', 'uses' => 'ShoppingCartController@updateEmail'],
    'delete.item' => [ 'method' => 'delete', 'path' =>'/items/{item_id}', 'uses' => 'ShoppingCartController@deleteItem'],
    'patch.item.quantity' => [ 'method' => 'patch', 'path' => '/items/{item_id}/quantity/{quantity}', 'uses' => 'ShoppingCartController@updateItemQuantity'],
    'get.coupon' => [ 'method' => 'get', 'path' => '/coupon', 'uses' => 'ShoppingCartController@getCoupon'],
    'delete.coupon' => [ 'method' => 'delete', 'path' => '/coupon', 'uses' => 'ShoppingCartController@deleteCoupon'],
    'put.coupon' => [ 'method' => 'put', 'path' => '/coupon/{coupon_code}', 'uses' => 'ShoppingCartController@putCoupon'],
    'put.billing_address' => [ 'method' => 'put', 'path' => '/billing_address', 'uses' => 'ShoppingCartController@setBillingAddress'],
    'put.shipping_address' => [ 'method' => 'put', 'path' => '/shipping_address', 'uses' =>  'ShoppingCartController@setShippingAddress'],
    'merge' => [ 'method' => 'post', 'path' => '/to/{to_cart_guid}', 'uses' => 'ShoppingCartController@mergeCart'],
    'get.customer' => [ 'method' => 'get', 'path' => '/customer', 'uses' => 'ShoppingCartController@getCustomer'],
    'put.customer' => [ 'method' => 'put', 'path' => '/customer', 'uses' => 'ShoppingCartController@setCustomer'],
];

Route::group(
    [
        'prefix' => '/api/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
        'as' => 'api:cart:'
    ], function () use ($apiRoutes) {
        foreach($apiRoutes as $name => $route) {
            $routeItem = Route::{$route['method']}(
                $route['path'],
                ['as' => $name, 'uses' => $route['uses']]
            );
            if ($route['middlewares'] ?? false) {
                $routeItem->middleware($route['middlewares']);
            }
        }
});