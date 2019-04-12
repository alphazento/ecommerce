<?php
    Route::options('/{all}', 
        '\Zento\Passport\Http\Controllers\Api\ZentoPassportController@apiOptions')
        ->where('all', '.*')->middleware('cors');

    Route::group(
        [
            'prefix' => '/rest/v1/oauth2',
            'namespace' => '\Zento\Passport\Http\Controllers\Api',
            'middleware' => ['setuppassport']
        ], function () {
        Route::post(
            '/token', 
            ['as' => 'oauth.zento_token', 'uses' => 'ZentoPassportController@issueToken']
        );
        Route::post(
            '/refresh', 
            ['as' => 'oauth.refresh', 'uses' => 'ZentoPassportController@refreshToken']
        );
        Route::post(
            '/register', 
            ['as' => 'oauth.register', 'uses' => 'ZentoPassportController@register']
        );
        Route::delete(
            '/logout', 
            ['as' => 'oauth.logout', 'uses' => 'ZentoPassportController@logout']
        )->middleware('auth:api');
    });