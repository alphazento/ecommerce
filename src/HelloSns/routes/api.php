<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\HelloSns\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api'],
    ], function () {
        Route::post(
            '/hellosns/connect',
            ['as' => 'api.hellosns.connect', 'uses' => 'HelloSnsController@tokenAccountConnect']
        );
    });
