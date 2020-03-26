<?php
$configs = [
    'namespace' => '\Zento\Backend\Http\Controllers\Api',
    'middleware' => ['backend', 'auth:api'],
    'prefix' => '/api/v1/admin',
    'scope' => 'backend',
    'catalog' => 'no-acl',
];

Route::group($configs, 
    function() {
        Route::get(
            '/dashboard/menus', 
            'DashboardController@menus'
        );

        Route::get(
            '/administrator', 
            '\Zento\Passport\Http\Controllers\ApiController@profile'
        );

        Route::get(
            '/metadata/datatable-schemas/{table}', 
            'AdminMetaDataController@datatableSchema'
        );

        Route::get(
            '/metadata/models/{model}', 
            'AdminMetaDataController@modelDefines'
        )
        ->where('model', '.*');
    }
);

$configs['catalog'] = 'Store Configuration';
Route::group($configs, function() {
        Route::get(
            '/configs/config-menus', 
            'StoreConfigController@menus'
        );

        Route::get(
            '/configs/groups/{l0}/{l1}', 
            'StoreConfigController@groups'
        );

        Route::post(
            '/configs/{key}', 
            'StoreConfigController@store'
        );
    }
);

$configs['catalog'] = 'Dynamic Attributes';
Route::group($configs, function() {
        Route::get(
            '/dynamic-attributes/{id}', 
             'DynamicAttributeController@attribute'
        );

        Route::get(
            '/dynamic-attributes/models/{model}', 
            'DynamicAttributeController@attributesOfModel'
        );

        Route::post(
            '/dynamic-attributes', 
            'DynamicAttributeController@store'
        );

        Route::patch(
            '/dynamic-attributes/{id}', 
            'DynamicAttributeController@update'
        );


        Route::get(
            '/dynamic-attributes/{id}/values', 
            'DynamicAttributeController@values'
        );

        Route::get(
            '/dynamic-attributes/{id}/sets', 
            'DynamicAttributeController@belongsSets'
        );

        // Route::post(
        //     '/dynamic-attributes/{id}/values', 
        //     'DynamicAttributeController@getAttribute'
        // );

        // Route::patch(
        //     '/dynamic-attributes/{id}/values/{m_id}',
        //     'DynamicAttributeController@getAttribute'
        // );

        Route::get(
            '/dynamic-attribute-sets/models/{model}', 
            'DynamicAttributeController@attributeSetsOfModel'
        );

        Route::get(
            '/dynamic-attribute-sets/{id}', 
            'DynamicAttributeController@attributeSet'
        );

        Route::post(
            '/dynamic-attribute-sets', 
            'DynamicAttributeController@createAttributeSet'
        );

        Route::patch(
            '/dynamic-attribute-sets/{id}', 
            'DynamicAttributeController@updateAttributeSet'
        );

        Route::put(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}', 
            'DynamicAttributeController@addToSet'
        );

        Route::delete(
            '/dynamic-attribute-sets/{attr_set_id}/attributes/{attr_id}',
            'DynamicAttributeController@deleteFromSet'
        );

        Route::patch('/model/{model}/{id}', 
            'ModelController@updateModel'
        );
    }
);

$configs['catalog'] = 'Upload Files';
Route::group($configs, function() {
        Route::post('/upload/{visibility}', 'FileUploadController@uploadFile')
            ->where('visibility', 'public|private');

        Route::post('/upload/{visibility}/{folder}', 'FileUploadController@uploadFile')
            ->where('visibility', 'public|private')
            ->where('folder', '.*');

        Route::get('/files-finder/{visibility}', 'StorageFileFinder@findFiles')
            ->where('visibility', 'public|private');

        Route::get('/files-finder/{visibility}/{folder}', 'StorageFileFinder@findFiles')
            ->where('visibility', 'public|private')
            ->where('folder', '.*');
    }
);

Route::group(
    [
        'prefix' => '/api/v1/admin/oauth2',
        'namespace' => '\Zento\Passport\Http\Controllers',
        'middleware' => ['backend', 'cors']
    ], function () {
    Route::post('/token',  'ApiController@issueToken');
});
