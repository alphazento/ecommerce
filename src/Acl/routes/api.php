<?php
//API entry
Route::group(
    [
        'namespace' => '\Zento\Acl\Http\Controllers\Api',
        'middleware' => ['adminapi', 'apicors'],
        'prefix' => '/rest/v1/admin/acl',
        'as'=>'apc:'
    ], function () {
        Route::get('/users',
            [
                'as'=>'get.users',
                'uses'=>'ApcController@users'
            ]
        );

        Route::post('/users',
            [
                'as'=>'add.user',
                'uses'=>'ApcController@putUser'
            ]
        );

        Route::get('/users/{id}',
            [
                'as'=>'get.users',
                'uses'=>'ApcController@getUser'
            ]
        );

        Route::delete('/users/{id}',
            [
                'as'=>'delete.user',
                'uses'=>'ApcController@deleteUser'
            ]
        );

        Route::post('/users/{id}',
            [
                'as'=>'update.user',
                'uses'=>'ApcController@updateUser'
            ]
        );

        Route::get('/users/{id}/groups',
        [
            'as'=>'get.groupsbyuser',
            'uses'=>'ApcController@getGroupsByUser'
        ]);

        Route::post('/users/{id}/groups',
        [
            'as'=>'add.groups.to.user',
            'uses'=>'ApcController@addGroups2User'
        ]);

        Route::delete('/users/{uid}/groups/{gid}',
        [
            'as'=>'del.groupbyuser',
            'uses'=>'ApcController@delGroupByUser'
        ]);

        Route::get('/users/{id}/permissions',
        [
            'as'=>'get.user.permissions',
            'uses'=>'ApcController@getUserPermissions'
        ]);

        Route::get('/users/{id}/white-permissions',
        [
            'as'=>'get.user.whitepermissions',
            'uses'=>'ApcController@getUserWhitePermissions'
        ]);

        Route::get('/users/{id}/black-permissions',
        [
            'as'=>'get.user.blackpermissions',
            'uses'=>'ApcController@getUserBlackPermissions'
        ]);

        Route::post('/users/{id}/white-permissions',
        [
            'as'=>'post.user.whitepermissions',
            'uses'=>'ApcController@addUserWhitePermission'
        ]);

        Route::post('/users/{id}/black-permissions',
        [
            'as'=>'post.user.blackpermissions',
            'uses'=>'ApcController@addUserBlackPermission'
        ]);

        Route::delete('/users/{uid}/white-permissions/{pid}',
        [
            'as'=>'delete.user.whitepermissions',
            'uses'=>'ApcController@removeUserWhitePermission'
        ]);

        Route::delete('/users/{uid}/black-permissions/{pid}',
        [
            'as'=>'delete.user.blackpermissions',
            'uses'=>'ApcController@removeUserBlackPermission'
        ]);


        Route::get('/groups',
            [
                'as'=>'get.groups',
                'uses'=>'ApcController@groups'
            ]
        );

        Route::post('/groups',
            [
                'as'=>'post.groups',
                'uses'=>'ApcController@addGroup'
            ]
        );

        Route::post('/groups/{id}',
            [
                'as'=>'post.groups',
                'uses'=>'ApcController@updateGroup'
            ]
        );

        Route::get('/groups/{id}/permissions',
            [
                'as'=>'get.groups.permissions',
                'uses'=>'ApcController@getGroupPermissions'
            ]
        );

        Route::post('/groups/{id}/permissions',
            [
                'as'=>'post.groups.permissions',
                'uses'=>'ApcController@addGroupPermissions'
            ]
        );

        Route::delete('/groups/{gid}/permissions/{pid}',
            [
                'as'=>'delete.groups.permissions',
                'uses'=>'ApcController@removeGroupPermission'
            ]
        );

        Route::get('/groups/{id}/users',
            [
                'as'=>'get.groups.users',
                'uses'=>'ApcController@getGroupUsers'
            ]
        );

        Route::post('/groups/{id}/users',
            [
                'as'=>'post.groups.users',
                'uses'=>'ApcController@addUsersToGroup'
            ]
        );

        Route::delete('/groups/{group_id}/users/{user_id}',
            [
                'as'=>'delete.groups.user',
                'uses'=>'ApcController@removeUserFromGroup'
            ]
        );

        Route::get('/permissions',
            [
                'as'=>'get.permissions',
                'uses'=>'ApcController@getPermissions'
            ]
        );

});
