<?php
return [
    "Zento_Catalog" => [
        "version" => "0.0.1",
        "vue_component" => true,
        "commands" => [],
        "providers" => [
            "\\Zento\\Catalog\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_Backend",
            "Zento_RouteAndRewriter",
        ],
    ],
];
