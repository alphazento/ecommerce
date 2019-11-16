<?php

Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\WebTheme\Http\Controllers',
        'middleware' => ['web']
    ], function () {
    Route::get('/returns',
        [
            'as' => 'returns',
            'uses' => 'UtilityController@returns'
        ]
    );
    Route::get('/terms-conditions',
        [
            'as' => 'terms-conditions',
            'uses' => 'UtilityController@terms_conditions'
        ]
    );

    Route::get('/',
        [
            'as' => 'home',
            'uses' => 'Web@home'
        ]
    );
});

