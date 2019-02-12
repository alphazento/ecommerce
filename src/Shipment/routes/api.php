<?php
$apiRoutes = [
    'shipment.estimate' => [ 'method' => 'post', 'path' => '/estimate/carts/{cart_guid}', 'uses' => 'ShipmentController@estimateShippingMethods', 'allow_guest' => false],
   ];

Route::group(
    [
        'prefix' => '/rest/v1/shipment',
        'namespace' => '\Zento\Shipment\Http\Controllers\Api',
        'middleware' => ['setuppassport', 'auth:api']
    ], function () use ($apiRoutes) {
        foreach($apiRoutes as $name => $route) {
            Route::{$route['method']}(
                $route['path'],
                ['as' => $name, 'uses' => $route['uses']]
            );
        }
});