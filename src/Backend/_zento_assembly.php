<?php
return [
    "Zento_Backend" => [
        "version" => "0.0.1",
        "commands" =>  [],
        'vuetheme_type'=>'backend',
        "providers" => [
            "\\Zento\\Backend\\Providers\\Entry"
        ],
        "listeners"=> [],
        "middlewaregroup"=> [
            "backend"=> [
                "main"=> [
                    "\\Zento\\Backend\\Http\\Middleware\\Backend",
                    "\\Zento\\Passport\\Http\\Middleware\\CORS"
                ]
            ]
        ]
    ]
];