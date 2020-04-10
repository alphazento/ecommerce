<?php
return [
    "Zento_ApiDocAdv"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\ApiDocAdv\\Provider"
        ],
        "views" => [
            "console" => 1,
            "namespaces" => [
                'apidoc' => 'apidoc'
            ],
        ],
        "depends"=> [
        ]
    ]
];