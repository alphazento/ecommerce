<?php
if (!env('ONLY_PURE_API')) {
    Route::group(
        [
            'prefix' => '/',
            'namespace' => '\Zento\SnsConnect\Http\Controllers',
            'middleware' => ['web']
        ], function () {
        Route::get(
            '/login/hellojs/callback', 
            ['as' => 'get.sns-login-callback', 'uses' => 'WebController@handleCallback']
        );

        Route::post(
            '/login/hellojs/callback', 
            ['as'=>'post.sns-login-callback', 'uses' => 'WebController@handleCallback']
        );
    });
}