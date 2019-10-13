<?php
return [
    'Zento_BladeTheme' => [
        "version"=> "0.0.1",
        "theme" => true,
        "commands"=> [],
        "providers"=> [
            "\\Zento\\BladeTheme\\Provider"
        ],
        "middlewares"=> [],
        "middlewaregroup"=> [
            'web' => [
                'post' => [
                    '\Zento\Kernel\ThemeManager\Middleware\ThemeByBrowser',
                ],
            ],
        ]
    ]
];