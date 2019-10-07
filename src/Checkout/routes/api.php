<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\Checkout\Http\Controllers',
        'middleware' => ['cors'],
        'as' => 'both:checkout:'
    ], function () {
        Route::post(
            '/checkout/orders',
            ['as' => 'checkout.post.order', 'uses' => 'ApiController@draftOrder']
        );
    }
);