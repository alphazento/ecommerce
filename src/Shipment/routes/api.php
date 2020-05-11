<?php

Route::group(
    [
        'prefix' => '/api/v1/shipment',
        'namespace' => '\Zento\Shipment\Http\Controllers\Api',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
    ], function () {
        Route::post('/estimate/carts/{cart_guid}',
            'ShipmentController@estimateShippingMethods');
    });
