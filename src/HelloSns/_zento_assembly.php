<?php
return [
    "Zento_HelloSns" => [
        "version" => "0.0.1",
        "vue_component" => true,
        "commands" => [],
        "providers" => [
            "\\Zento\\HelloSns\\Providers\\Plugin",
        ],
        "depends" => [
            'Zento_Backend',
            'Zento_BladeTheme',
        ],
    ],
];
