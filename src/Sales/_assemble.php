<?php
return [
    "Zento_Sales"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\Sales\\Providers\\Entry"
        ],
        "listeners"=> [
            "Zento\\ShoppingCart\\Event\\ShoppingCartUpdated"=> ["\\Zento\\Sales\\Event\\Listener\\ShoppingCartUpdated"],
            "Zento\\Checkout\\Event\\DraftOrder"=> [
                "20"=> "\\Zento\\Sales\\Event\\Listener\\DraftOrder"
            ]
        ]
    ]
];