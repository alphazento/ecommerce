<?php
return [
    "Zento_ReactApp"=> [
        "version"=> "0.0.1",
        "commands"=> [
            "\\Zento\\ReactApp\\Console\\Commands\\BuildApp"
        ],
        "providers"=> [
            "\\Zento\\ReactApp\\Providers\\Entry"
        ],
        "depends"=>[
            "Zento_RouteAndRewriter",
            "Zento_Catalog"
        ],
        "theme"=> true
    ]
];