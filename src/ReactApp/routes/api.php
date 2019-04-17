<?php
Route::group(
    [
        'prefix' => '/rest/v1',
        'namespace' => '\Zento\ReactApp\Http\Controllers',
        'middleware' => ['cors']
    ], function () {
        Route::get(
            '/reactapp/configs', 
            ['as' => 'reactapp.configs', 'uses' => 'ApiController@configs']
        );
        Route::get(
            '/reactapp/cms/home', 
            ['as' => 'reactapp.cms.home', 'uses' => 'ApiController@cmsHome']
        );
        Route::get(
            '/urlrewrite',
            ['uses'=>'ApiController@getUrlRewriteTo']
        );
});
