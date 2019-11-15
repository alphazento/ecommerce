<?php
Route::group(
    [
        'prefix' => '/api/v1',
        'namespace' => '\Zento\ReactApp\Http\Controllers',
        'middleware' => ['cors', 'guesttoken', 'auth:api']
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
