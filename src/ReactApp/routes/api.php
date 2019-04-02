<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\ReactApp\Http\Controllers',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/configs/reactapp', 
            ['as' => 'configs.reactapp', 'uses' => 'ApiController@configs']
        );
        Route::get(
            '/urlrewrite',
            ['uses'=>'ApiController@getUrlRewriteTo']
        );
});
