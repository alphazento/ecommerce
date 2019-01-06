<?php
Route::group(
    [
        'namespace' => '\Zento\Backend\Http\Controllers\Api',
        'middleware' => ['adminapi'],
        'prefix' => '/admin/rest/v1',
    ], function() {
        Route::get(
            '/configs/menus', 
            ['as' => 'admin.configs.menus', 'uses' => 'ConfigurationController@getMenus']
        );

        Route::get(
            '/configs/groups/{l0}/{l1}', 
            ['as' => 'admin.configs.groups', 'uses' => 'ConfigurationController@getMenuDetailGroups']
        );

        Route::post(
            '/configs/values', 
            ['as' => 'admin.configs.values', 'uses' => 'ConfigurationController@getConfigValues']
        );

        Route::post(
            '/configs/{key}', 
            ['as' => 'admin.configs.set.value', 'uses' => 'ConfigurationController@setConfigValue']
        );
    }
);
