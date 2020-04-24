<?php
return [
    "Zento_DownloadableProduct"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\DownloadableProduct\\Providers\\Entry"
        ],
        "depends"=>[
            "Zento_Catalog",
            "Zento_CatalogSearch"
        ]
    ]
];