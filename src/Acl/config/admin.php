<?php

return [
    'ui_schema' => [
        [
            'is_menu'=>true,
            'name'=>'root_systems',
            'title'=>'Systems',
            'image'=> "/images/system.png",
        ],
        [
            'is_menu'=>true,
            'name'=>'root_systems_apc',
            'parent'=>'root_systems',
            'title'=>'APC',
            'link'=>'/stores/default/systems/apc'
        ],
    ]
];
