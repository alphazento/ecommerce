<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers\Api',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin',
        'scope' => 'backend',
        'group' => 'admin-system',
    ], function() {
        Route::get(
            '/dashboard/menus', 
            'DashboardController@getMenus'
        )->unshiftMiddleware('ignore_acl');

        Route::get(
            '/configs/menus', 
            'ConfigurationController@getMenus'
        );

        Route::get(
            '/configs/groups/{l0}/{l1}', 
            'ConfigurationController@getConfigGroups'
        );

        Route::post(
            '/configs/{key}', 
            'ConfigurationController@setConfigValue'
        );

        Route::get(
            '/dynamic-attributes/{id}', 
             'DAController@getAttribute'
        );

        Route::get(
            '/dynamic-attributes/models/{model}', 
            'DAController@getModelAttributes'
        );

        Route::post(
            '/dynamic-attributes', 
            'DAController@createAttribute'
        );

        Route::patch(
            '/dynamic-attributes/{id}', 
            'DAController@updateAttribute'
        );


        Route::get(
            '/dynamic-attributes/{id}/values', 
            'DAController@getAttributeValues'
        );

        Route::get(
            '/dynamic-attributes/{id}/sets', 
            'DAController@getAttributeBelongsSets'
        );

        Route::post(
            '/dynamic-attributes/{id}/values', 
            'DAController@getAttribute'
        );

        Route::patch(
            '/dynamic-attributes/{id}/values/{m_id}',
            'DAController@getAttribute'
        );

        Route::get(
            '/dynamic-attribute-sets/models/{model}', 
            'DAController@getModelAttributeSets'
        );

        Route::get(
            '/dynamic-attribute-sets/{id}', 
            'DAController@getAttributeSet'
        );

        Route::post(
            '/dynamic-attribute-sets', 
            'DAController@createAttributeSet'
        );

        Route::patch(
            '/dynamic-attribute-sets/{id}', 
            'DAController@updateAttributeSet'
        );

        Route::put(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}', 
            'DAController@addAttributeToSet'
        );

        Route::delete(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}',
            'DAController@deleteAttributeFromSet'
        );

        Route::patch('/model/{model}/{id}', 
            'ModelController@updateModel'
        );

        Route::get(
            '/administrator', 
            '\Zento\Passport\Http\Controllers\ApiController@profile'
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
