<?php
return [
    "Zento_DownloadableProduct" => [
        "version" => "0.0.1",
        "commands" => [],
        "providers" => [
            "\\Zento\\DownloadableProduct\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_Catalog",
            "Zento_CatalogSearch",
        ],
    ],
];
