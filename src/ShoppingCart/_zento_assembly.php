<?php
return [
    "Zento_ShoppingCart"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\ShoppingCart\\Providers\\Plugin"
        ],
        "listeners"=> [
            // "Zento\\Sales\\Event\\OrderCreatedEvent"=> [
            //     // "20"=> "\\Zento\\ShoppingCart\\Event\\Listener\\OrderCreated"
            // ],
            "Zento\\Customer\\Event\\PassportTokenIssued"=> [
            ]
        ],
        "depends"=> [
            "Zento_Catalog",
            "Zento_Customer"
        ]
    ]
];