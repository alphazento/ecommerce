<?php
Route::group(
    [
        'prefix' => '/hellosns',
        'namespace' => '\Zento\HelloSns\Http\Controllers',
        'middleware' => ['web']
    ], function () {
        Route::post(
            '/connect', 
            ['as' => 'web.hellosns.connect', 'uses' => 'HelloSnsController@sessionAccountConnect']
        );
});
