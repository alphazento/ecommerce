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
            // 'web' => [
            //     'post' => [
            //         '\Zento\Kernel\ThemeManager\Middleware\ThemeByBrowser',
            //     ],
            // ],

            'web' => [
                'main' => [
                    \App\Http\Middleware\EncryptCookies::class,
                    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                    \Illuminate\Session\Middleware\StartSession::class,
                    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                    // \App\Http\Middleware\VerifyCsrfToken::class,
                    \Zento\Kernel\Booster\Middleware\VerifyCsrfToken,
                    \Illuminate\Routing\Middleware\SubstituteBindings::class,
                    Zento\Kernel\ThemeManager\Middleware\ThemeByBrowser::class,
                ]
              ],
        ],
        "depends"=> [
            "Zento_Customer",
            "Zento_Catalog",
            "Zento_WebShoppingCart"
        ]
    ]
];