<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers\Api',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin',
        'as' => 'admin:system:'
    ], function() {
        Route::get(
            '/dashboard/menus', 
            ['as' => 'admin.dashboard.menus', 'uses' => 'DashboardController@getMenus']
        );

        Route::get(
            '/configs/menus', 
            ['as' => 'admin.configs.menus', 'uses' => 'ConfigurationController@getMenus']
        );

        Route::get(
            '/configs/groups/{l0}/{l1}', 
            ['as' => 'admin.configs.groups', 'uses' => 'ConfigurationController@getConfigGroups']
        );

        // Route::get(
        //     '/configs/values/{l0}/{l1}', 
        //     ['as' => 'admin.configs.values', 'uses' => 'ConfigurationController@getGroupValues']
        // );

        Route::post(
            '/configs/{key}', 
            ['as' => 'admin.configs.set.value', 'uses' => 'ConfigurationController@setConfigValue']
        );

        Route::get(
            '/dynamicattributes/{model}', 
            ['as' => 'admin.da.get', 'uses' => 'DAController@getAttributes']
        );

        Route::post(
            '/dynamicattributes', 
            ['as' => 'admin.post.da', 'uses' => 'DAController@createAttribute']
        );

        Route::patch(
            '/dynamicattributes/{id}', 
            ['as' => 'admin.patch.da', 'uses' => 'DAController@updateAttribute']
        );

        Route::patch('/model/{model}/{id}', 
            ['as' => 'admin.put.model', 'uses' => 'ModelController@updateModel']
        );

        Route::get(
            '/administrator', 
            [
                'as' => 'customer.getbyid', 
                'uses' => '\Zento\Passport\Http\Controllers\ApiController@profile'
            ]
        );

        Route::post(
            '/upload/{visibility}',
            ['as'=>'post.upload', 'uses'=>'FileUploadController@uploadFile']
        )->where('visibility', 'public|private');

        Route::post(
            '/upload/{visibility}/{folder}',
            ['as'=>'post.upload.to.folder', 'uses'=>'FileUploadController@uploadFile']
        )->where('visibility', 'public|private');

        Route::get('/files-finder/{visibility}', 
            ['as'=>'get.files-finder.in-folder', 'uses'=>'StorageFileFinder@findFiles']
        )->where('visibility', 'public|private');

        Route::get('/files-finder/{visibility}/{folder}', 
            ['as'=>'get.files-finder', 'uses'=>'StorageFileFinder@findFiles']
        )->where('visibility', 'public|private');
    }
);


Route::group(
    [
        'prefix' => '/api/v1/admin/oauth2',
        'namespace' => '\Zento\Passport\Http\Controllers',
        'middleware' => ['backend', 'cors']
    ], function () {
    Route::post(
        '/token', 
        ['uses' => 'ApiController@issueToken']
    );
});
