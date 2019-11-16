<?php
return [
    "Zento_ShoppingCart"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\ShoppingCart\\Providers\\Entry"
        ],
        "listeners"=> [
            "Zento\\Checkout\\Event\\OrderCreated"=> [
                "20"=> "\\Zento\\ShoppingCart\\Event\\Listener\\OrderCreated"
            ],
            "Zento\\Customer\\Event\\PassportTokenIssued"=> [
            ]
        ],
        "depends"=> [
            "Zento_Catalog",
            "Zento_Customer"
        ]
    ]
];