<?php
return [
    "Zento_FreeShipping" => [
        "version" => "0.0.1",
        "commands" => [],
        "providers" => [
            "\\Zento\\FreeShipping\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_Shipment",
        ],
    ],
];
