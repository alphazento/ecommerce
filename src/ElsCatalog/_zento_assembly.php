<?php
return [
    "Zento_ElsCatalog"=> [
        "version"=> "0.0.1",
        "commands"=> [
            "\\Zento\\ElsCatalog\\Console\\Commands\\SyncCategory2Els"
        ],
        "providers"=> [
            "\\Zento\\ElsCatalog\\Providers\\Entry"
        ],
        "depends"=> [
            "Zento_Catalog",
            "Zento_CatalogSearch"
        ]
    ]
];