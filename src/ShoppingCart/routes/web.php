<?php

if (!env('ONLY_PURE_API')) {
    $apiRoutes = [
        'ajax.cart.add.item' => [ 'method' => 'post', 'path' =>'/{cart_guid}/items', 'uses' => 'ShoppingCartController@addItem'],
        'ajax.cart.update.email' => [ 'method' => 'post', 'path' =>'/{cart_guid}/email/', 'uses' => 'ShoppingCartController@updateEmail'],
        'ajax.cart.delete.item' => [ 'method' => 'delete', 'path' =>'/{cart_guid}/items/{item_id}', 'uses' => 'ShoppingCartController@deleteItem'],
        'ajax.cart.patch.item.quantity' => [ 'method' => 'patch', 'path' => '/{cart_guid}/items/{item_id}/quantity/{quantity}', 'uses' => 'ShoppingCartController@updateItemQuantity'],
        'ajax.cart.get.coupon' => [ 'method' => 'get', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@getCoupon'],
        'ajax.cart.delete.coupon' => [ 'method' => 'delete', 'path' => '/{cart_guid}/coupon', 'uses' => 'ShoppingCartController@deleteCoupon'],
        'ajax.cart.put.coupon' => [ 'method' => 'put', 'path' => '/{cart_guid}/coupon/{coupon_code}', 'uses' => 'ShoppingCartController@putCoupon'],
        'ajax.cart.put.billing_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/billing_address', 'uses' => 'ShoppingCartController@setBillingAddress'],
        'ajax.cart.put.shipping_address' => [ 'method' => 'put', 'path' => '/{cart_guid}/shipping_address', 'uses' =>  'ShoppingCartController@setShippingAddress'],
        'ajax.cart.get.customer' => [ 'method' => 'get', 'path' => '/{cart_guid}/customer', 'uses' => 'ShoppingCartController@getCustomer'],
        'ajax.cart.put.customer' => [ 'method' => 'put', 'path' => '/{cart_guid}/customer/{customer_id}', 'uses' => 'ShoppingCartController@setCustomer'],
    ];
    
    Route::group(
        [
            'prefix' => '/ajax/cart',
            'namespace' => '\Zento\ShoppingCart\Http\Controllers\Api',
            'middleware' => ['cors', 'web'],
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
}
