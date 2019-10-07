<?php
return [
    "Zento_Passport"=> [
        "version" => "0.0.1",
        "commands" => [
        ],
        "providers" => [
            "\\Zento\\Passport\\Providers\\Entry"
        ],
        "middlewares"=> [
            "cors"=> "\\Zento\\Passport\\Http\\Middleware\\CORS",
            "scopes"=> "\\Laravel\\Passport\\Http\\Middleware\\CheckScopes=>=>class",
            "scope"=> "\\Laravel\\Passport\\Http\\Middleware\\CheckForAnyScope=>=>class"
        ],
        "middlewaregroup"=> []
    ]
];