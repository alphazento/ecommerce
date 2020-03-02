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
            '/dynamic-attributes/{id}', 
            ['as' => 'admin.da.get.by.id', 'uses' => 'DAController@getAttribute']
        );

        Route::get(
            '/dynamic-attributes/models/{model}', 
            ['as' => 'admin.da.get.by.model', 'uses' => 'DAController@getModelAttributes']
        );

        Route::post(
            '/dynamic-attributes', 
            ['as' => 'admin.post.da', 'uses' => 'DAController@createAttribute']
        );

        Route::patch(
            '/dynamic-attributes/{id}', 
            ['as' => 'admin.patch.da', 'uses' => 'DAController@updateAttribute']
        );


        Route::get(
            '/dynamic-attributes/{id}/values', 
            ['uses' => 'DAController@getAttributeValues']
        );

        Route::post(
            '/dynamic-attributes/{id}/values', 
            ['uses' => 'DAController@getAttribute']
        );

        Route::patch(
            '/dynamic-attributes/{id}/values/{m_id}', 
            ['uses' => 'DAController@getAttribute']
        );

        Route::get(
            '/dynamic-attribute-sets/models/{model}', 
            ['as' => 'admin.da_set.get.all', 'uses' => 'DAController@getModelAttributeSets']
        );

        Route::get(
            '/dynamic-attribute-sets/{id}', 
            ['as' => 'admin.da_set.get', 'uses' => 'DAController@getAttributeSet']
        );

        Route::post(
            '/dynamic-attribute-sets', 
            ['as' => 'admin.post.da_set', 'uses' => 'DAController@createAttributeSet']
        );

        Route::patch(
            '/dynamic-attribute-sets/{id}', 
            ['as' => 'admin.patch.da_set', 'uses' => 'DAController@updateAttributeSet']
        );

        Route::put(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}', 
            ['as' => 'admin.put.da.to.set', 'uses' => 'DAController@addAttributeToSet']
        );

        Route::delete(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}', 
            ['as' => 'admin.delete.da.from.set', 'uses' => 'DAController@deleteAttributeFromSet']
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
        )->where('visibility', 'public|private')
        ->where('folder', '.*');

        Route::get('/files-finder/{visibility}', 
            ['as'=>'get.files-finder.in-folder', 'uses'=>'StorageFileFinder@findFiles']
        )->where('visibility', 'public|private');

        Route::get('/files-finder/{visibility}/{folder}', 
            ['as'=>'get.files-finder', 'uses'=>'StorageFileFinder@findFiles']
        )->where('visibility', 'public|private')
         ->where('folder', '.*');
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
