<?php
$configs = [
    'namespace' => '\Zento\BraintreePayment\Http\Controllers\Api',
    'middleware' => ['cors', 'guesttoken', 'auth:api'],
    'prefix' => '/api/v1/braintree',
];

Route::group($configs,
    function () {
        Route::get(
            '/token',
            'BraintreeController@token'
        );
    }
);
