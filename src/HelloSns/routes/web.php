<?php

Route::group(
    [
        'prefix' => '/',
        'namespace' => '\Zento\HelloSns\Http\Controllers',
        'middleware' => ['web']
    ], function () {
        Route::get(
            '/hellosns/callback', 
            ['as' => 'hellosns.callback', 'uses' => 'WebController@handleCallback']
        );
    }
);