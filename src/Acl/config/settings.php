<?php
return [
	'version'=>'0.0.1',
	'module'=>[
		'providers'=>[
            '\Zento\Acl\Providers\Entry',
        ],
        'middlewaregroup' => [
            'adminapi' => [
                'after' => [
                    '\Zento\Acl\Http\Middleware\PermissionCheck'
                ],
            ],
        ],
		'commands'=>[
            '\Zento\Acl\Console\Commands\SyncRoute',
            '\Zento\Acl\Console\Commands\AddUser',
            '\Zento\Acl\Console\Commands\EnableUser',
            '\Zento\Acl\Console\Commands\DisableUser',
            '\Zento\Acl\Console\Commands\UserPassword',
        ],
        'dependency' => ['Admin', 'OAuth2', 'Store'],
	],
];
