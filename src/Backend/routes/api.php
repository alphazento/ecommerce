<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers\Api',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin',
        'as' => 'admin:system:'
    ], function() {
        Route::get(
            '/configs/menus', 
            ['as' => 'admin.configs.menus', 'uses' => 'ConfigurationController@getMenus']
        );

        Route::get(
            '/configs/groups/{l0}/{l1}', 
            ['as' => 'admin.configs.groups', 'uses' => 'ConfigurationController@getConfigGroups']
        );

        Route::get(
            '/configs/values/{l0}/{l1}', 
            ['as' => 'admin.configs.values', 'uses' => 'ConfigurationController@getGroupValues']
        );

        Route::put(
            '/configs/{key}', 
            ['as' => 'admin.configs.set.value', 'uses' => 'ConfigurationController@setConfigValue']
        );

        Route::get(
            '/dynamicattributes/{model}', 
            ['as' => 'admin.da.get', 'uses' => 'DAController@getAttributes']
        );

        Route::post(
            '/dynamicattributes/{id}', 
            ['as' => 'admin.put.da', 'uses' => 'DAController@updateAttribute']
        );

        Route::put('/model/{model}/{id}', 
            ['as' => 'admin.put.model', 'uses' => 'ModelController@updateModel']
        );

        Route::get(
            '/administrator', 
            [
                'as' => 'customer.getbyid', 
                'uses' => '\Zento\Passport\Http\Controllers\ApiController@profile'
            ]
        );
    }
);


Route::group(
    [
        'prefix' => '/api/v1/admin/oauth2',
        'namespace' => '\Zento\Customer\Http\Controllers\Api',
        'middleware' => ['backend', 'cors']
    ], function () {
    Route::post(
        '/token', 
        ['uses' => 'PassportController@issueToken']
    );
    Route::post(
        '/register', 
        ['uses' => 'PassportController@register']
    );
    Route::post(
        '/token/google', 
        ['as' => 'admin.oauth.token.google', 
        'uses' => '\Zento\Passport\Http\Controllers\ApiController@issueTokenConnectGoogle']
    );
});
