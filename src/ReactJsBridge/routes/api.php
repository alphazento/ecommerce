<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\ReactJsBridge\Http\Controllers',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/reactjs/configs', 
            ['as' => 'reactjs.configs', 'uses' => 'ApiController@configs']
        );
        Route::get(
            '/urlrewrite',
            ['uses'=>'ApiController@getUrlRewriteTo']
        );
});