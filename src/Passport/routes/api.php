<?php
    Route::options('/{all}', 
        '\Zento\Passport\Http\Controllers\ApiController@apiHttpOptions')
        ->where('all', '.*')->middleware('cors');

    Route::group(
        [
            'prefix' => '/api/v1/oauth2',
            'namespace' => '\Zento\Passport\Http\Controllers',
            'middleware' => ['setuppassport']
        ], function () {
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
    });