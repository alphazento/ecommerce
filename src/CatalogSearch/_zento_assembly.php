<?php
return [
    "Zento_CatalogSearch" => [
        "version" => "0.0.1",
        "commands" => [
            "\\Zento\\CatalogSearch\\Console\\Commands\\FulltextIndex",
        ],
        "providers" => [
            "\\Zento\\CatalogSearch\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_Catalog",
            "Zento_RouteAndRewriter",
        ],
    ],
];
