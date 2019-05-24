<?php
//API entry
Route::group(
    [
        'namespace' => '\Zento\Acl\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin/acl',
        'as' => 'admin:acl:'
    ], function () {
        Route::get('/users',
            [
                'as'=>'get.users',
                'uses'=>'AclController@users'
            ]
        );

        Route::post('/users',
            [
                'as'=>'add.user',
                'uses'=>'AclController@putUser'
            ]
        );

        Route::get('/users/{id}',
            [
                'as'=>'get.users',
                'uses'=>'AclController@getUser'
            ]
        );

        Route::delete('/users/{id}',
            [
                'as'=>'delete.user',
                'uses'=>'AclController@deleteUser'
            ]
        );

        Route::post('/users/{id}',
            [
                'as'=>'update.user',
                'uses'=>'AclController@updateUser'
            ]
        );

        Route::get('/users/{id}/groups',
        [
            'as'=>'get.groupsbyuser',
            'uses'=>'AclController@getGroupsByUser'
        ]);

        Route::post('/users/{id}/groups',
        [
            'as'=>'add.groups.to.user',
            'uses'=>'AclController@addGroups2User'
        ]);

        Route::delete('/users/{uid}/groups/{gid}',
        [
            'as'=>'del.groupbyuser',
            'uses'=>'AclController@delGroupByUser'
        ]);

        Route::get('/users/{id}/permissions',
        [
            'as'=>'get.user.permissions',
            'uses'=>'AclController@getUserPermissions'
        ]);

        Route::get('/users/{id}/white-permissions',
        [
            'as'=>'get.user.whitepermissions',
            'uses'=>'AclController@getUserWhitePermissions'
        ]);

        Route::get('/users/{id}/black-permissions',
        [
            'as'=>'get.user.blackpermissions',
            'uses'=>'AclController@getUserBlackPermissions'
        ]);

        Route::post('/users/{id}/white-permissions',
        [
            'as'=>'post.user.whitepermissions',
            'uses'=>'AclController@addUserWhitePermission'
        ]);

        Route::post('/users/{id}/black-permissions',
        [
            'as'=>'post.user.blackpermissions',
            'uses'=>'AclController@addUserBlackPermission'
        ]);

        Route::delete('/users/{uid}/white-permissions/{pid}',
        [
            'as'=>'delete.user.whitepermissions',
            'uses'=>'AclController@removeUserWhitePermission'
        ]);

        Route::delete('/users/{uid}/black-permissions/{pid}',
        [
            'as'=>'delete.user.blackpermissions',
            'uses'=>'AclController@removeUserBlackPermission'
        ]);


        Route::get('/groups',
            [
                'as'=>'get.groups',
                'uses'=>'AclController@groups'
            ]
        );

        Route::post('/groups',
            [
                'as'=>'post.groups',
                'uses'=>'AclController@addGroup'
            ]
        );

        Route::post('/groups/{id}',
            [
                'as'=>'post.groups',
                'uses'=>'AclController@updateGroup'
            ]
        );

        Route::get('/groups/{id}/permissions',
            [
                'as'=>'get.groups.permissions',
                'uses'=>'AclController@getGroupPermissions'
            ]
        );

        Route::post('/groups/{id}/permissions',
            [
                'as'=>'post.groups.permissions',
                'uses'=>'AclController@addGroupPermissions'
            ]
        );

        Route::delete('/groups/{gid}/permissions/{pid}',
            [
                'as'=>'delete.groups.permissions',
                'uses'=>'AclController@removeGroupPermission'
            ]
        );

        Route::get('/groups/{id}/users',
            [
                'as'=>'get.groups.users',
                'uses'=>'AclController@getGroupUsers'
            ]
        );

        Route::post('/groups/{id}/users',
            [
                'as'=>'post.groups.users',
                'uses'=>'AclController@addUsersToGroup'
            ]
        );

        Route::delete('/groups/{group_id}/users/{user_id}',
            [
                'as'=>'delete.groups.user',
                'uses'=>'AclController@removeUserFromGroup'
            ]
        );

        Route::get('/permissions',
            [
                'as'=>'get.permissions',
                'uses'=>'AclController@getPermissions'
            ]
        );

});
