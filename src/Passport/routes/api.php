<?php
Route::options('/api/{all}',
    '\Zento\Passport\Http\Controllers\ApiController@apiHttpOptions')
    ->where('all', '.*')->middleware('cors');
// ->where('all', '^(?!api/).*$')->middleware('cors');
Route::group(
    [
        'prefix' => '/api/v1/oauth2',
        'namespace' => '\Zento\Passport\Http\Controllers',
        'middleware' => ['cors'],
    ], function () {
        // Route::post(
        //     '/token/guest',
        //     ['as' => 'oauth.token.guest', 'uses' => 'ApiController@guestToken']
        // )->unshiftMiddleware('guesttoken:normal');

        Route::post(
            '/token',
            ['as' => 'oauth.token', 'uses' => 'ApiController@issueToken']
        );

        Route::post(
            '/refresh',
            ['as' => 'oauth.refresh', 'uses' => 'ApiController@refreshToken']
        );

        Route::post(
            '/register',
            ['as' => 'oauth.register', 'uses' => 'ApiController@register']
        );

        Route::delete(
            '/logout',
            ['as' => 'oauth.logout', 'uses' => 'ApiController@logout']
        )->middleware('auth:api');

        Route::get(
            '/profile',
            ['as' => 'oauth.profile', 'uses' => 'ApiController@profile']
        )->middleware('auth:api');
    });
