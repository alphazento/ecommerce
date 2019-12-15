<?php
return [
    "Zento_Customer"=>[
        "version" => "0.0.1",
        "commands" => [
        ],
        "providers" => [
            "\\Zento\\Customer\\Providers\\Entry"
        ],
        "listeners"=> [
            "Zento\\Customer\\Event\\PassportTokenIssued"=> [
            ]
        ],
        "middlewaregroup"=> [
            
        ],
        "middlewares"=> [
            'guest' => '\Zento\Customer\Http\Middleware\RedirectIfAuthenticated'
        ],
        "depends"=> [
            "Zento_Passport"
        ],
        'tony' => 1
    ]
];