<?php
return [
    "Zento_ConfigurableProduct" => [
        "version" => "0.0.1",
        "commands" => [],
        "providers" => [
            "\\Zento\\ConfigurableProduct\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_Catalog",
            "Zento_CatalogSearch",
        ],
    ],
];
