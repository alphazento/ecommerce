<?php
//API entry
Route::group(
    [
        'namespace' => '\Zento\Acl\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin/acl/{scope}',
        'scope' => 'admin',
        'catalog' => 'acl-user-manager',
    ], function () {
        Route::get('/me', 'AclUserController@me')->unshiftMiddleware('ignore_acl');
        Route::get('/users', 'AclUserController@users');
        Route::get('/users/{id}', 'AclUserController@user');

        Route::post('/users', 'AclUserController@store');
        Route::patch('/users/{id}', 'AclUserController@update');
        Route::delete('/users/{id}', 'AclUserController@delete');
        Route::get('/users/{id}/roles', 'AclUserController@roles');
        Route::post('/users/{id}/roles', 'AclUserController@storeRoles');
        Route::delete('/users/{uid}/roles/{gid}', 'AclUserController@delGroupByUser');

        Route::get('/users/{id}/routes', 'AclUserController@routes');
        Route::get('/users/{id}/whiteroutes', 'AclController@whiteroutes');
        Route::get('/users/{id}/blackroutes', 'AclController@blackroutes');

        Route::post('/users/{id}/whiteroutes',
            'AclController@storeWhiteRoutes'
        );

        Route::post('/users/{id}/blackroutes',
            'AclController@storeBlackRoutes'
        );

        Route::delete('/users/{id}/whiteroutes/{route_id}',
            'AclController@deleteWhiteRoute'
        );

        Route::delete('/users/{id}/blackroutes/{route_id}',
            'AclController@deleteBlackRoute'
        );
    }
);

Route::group(
    [
        'namespace' => '\Zento\Acl\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin/acl/{scope}',
        'scope' => 'admin',
        'catalog' => 'acl-role-manager',
    ], function() {
        Route::get('/roles', 'AclRoleController@roles');
        Route::post('/roles', 'AclRoleController@store');
        Route::patch('/roles/{id}', 'AclRoleController@update');

        Route::get('/roles/{id}/routes', 'AclRoleController@routes');
        Route::post('/roles/{id}/routes', 'AclRoleController@storeRoutes');
        Route::delete('/roles/{id}/routes/{route_id}', 'AclRoleController@deleteRoute');

        Route::get('/roles/{id}/users', 'AclRoleController@users');
        Route::get('/roles/{id}/users-with-candidates', 'AclRoleController@userWithCandidate');
        Route::post('/roles/{id}/users', 'AclRoleController@storeUsers');
        Route::delete('/roles/{id}/users/{user_id}', 'AclRoleController@deleteUser');
    }
);

Route::group(
    [
        'namespace' => '\Zento\Acl\Http\Controllers',
        'middleware' => ['backend', 'auth:api'],
        'prefix' => '/api/v1/admin/acl/{scope}',
        'scope' => 'admin',
        'catalog' => 'acl-route-manager',
    ], function() {
        Route::get('/routes', 'AclRouteController@routes');
    }
);