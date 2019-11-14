<?php
$apiRoutes = [
    'cart.create' => [ 'method' => 'post', 'path' => '/', 'uses' => 'ShoppingCartController@createCart'],
    'cart.getone' => [ 'method' => 'get', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@getCart'],
    'cart.delete' => [ 'method' => 'delete', 'path' =>'/{cart_guid}', 'uses' => 'ShoppingCartController@deleteCart'],
    'cart.add.item' => [ 'method' => 'post', 'path' =>'/{cart_guid}/items', 'uses' => 'ShoppingCartController@addItem'],
    'cart.update.email' => [ 'method' => 'post', 'path' =>'/{cart_guid}/email/', 'uses' => 'ShoppingCartController@updateEmail'],
    'cart.delete.item' => [ 'method' => 'delete', 'path' =>'/{cart_guid}/items/{item_id}', 'uses' => 'ShoppingCartController@deleteItem'],
    'cart.patch.item.quantity' => [ 'method' => 'patch', 'path' => '/{cart_guid}/items/{item_id}/quantity/{quantity}', 'uses' => 'ShoppingCartController@updateItemQuantity'],
    'cart.get.coupon' => [ 'method' => 'get', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@getCoupon'],
    'cart.delete.coupon' => [ 'method' => 'delete', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@deleteCoupon'],
    'cart.put.coupon' => [ 'method' => 'put', 'path' => '/{cart_guid}/coupon/{coupon_code}', 'uses' => 'ShoppingCartController@putCoupon'],
    'cart.put.billing_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@setBillingAddress'],
    'cart.put.shipping_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/shipping_address', 'uses' =>  'ShoppingCartController@setShippingAddress'],
    'cart.merge' => [ 'method' => 'post', 'path' => '/{cart_guid}/to/{to_cart_guid}', 'uses' => 'ShoppingCartController@mergeCart'],
    'cart.get.customer' => [ 'method' => 'get', 'path' => '/{cart_guid}/customer', 'uses' => 'ShoppingCartController@getCustomer'],
    'cart.put.customer' => [ 'method' => 'put', 'path' => '/{cart_guid}/customer/{customer_id}', 'uses' => 'ShoppingCartController@setCustomer'],
];

Route::group(
    [
        'prefix' => '/api/v1/cart',
        'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
        'middleware' => ['cors', 'auth:api'],
        'as' => 'both:cart:'
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