<?php

Route::group(
    [
        'prefix' => '/rest/v1/oauth',
        'namespace' => '\Zento\Passport\Http\Controllers\Api',
        'middleware' => ['apipassport']
    ], function () {
    Route::post(
        '/zento_token', 
        ['as' => 'oauth.zento_token', 'uses' => 'ZentoPassportController@issueToken']
    );
    Route::post(
        '/register', 
        ['as' => 'oauth.register', 'uses' => 'ZentoPassportController@register']
    );
});