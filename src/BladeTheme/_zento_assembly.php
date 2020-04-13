<?php
return [
    'Zento_BladeTheme' => [
        "version"=> "0.0.1",
        "theme" => true,
        "commands"=> [
            '\Zento\BladeTheme\Console\Commands\PrepareVueBlade'
        ],
        "providers"=> [
            "\\Zento\\BladeTheme\\Provider"
        ],
        "middlewares"=> [],
        "middlewaregroup"=> [
            'web' => [
                'main' => [
                    \Illuminate\Cookie\Middleware\EncryptCookies::class,
                    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                    \Illuminate\Session\Middleware\StartSession::class,
                    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                    \Zento\Kernel\Booster\Middleware\VerifyCsrfToken::class,
                    \Illuminate\Routing\Middleware\SubstituteBindings::class,
                    \Zento\Kernel\ThemeManager\Middleware\ThemeByBrowser::class, 
                    \Zento\Customer\Http\Middleware\AuthGuestUser::class,
                    \Zento\BladeTheme\Http\Middleware\WebDataPrepare::class
                ]
              ],
        ],
        "depends"=> [
            "Zento_Customer",
            "Zento_Catalog",
        ]
    ]
];