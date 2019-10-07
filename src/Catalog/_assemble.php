<?php
return [
    "Zento_Catalog"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\Catalog\\Providers\\Entry"
        ],
        "depends"=>[
            "Zento_RouteAndRewriter"
        ]
    ]
];