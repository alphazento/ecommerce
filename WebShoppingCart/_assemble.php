<?php
return [
    "Zento_WebShoppingCart"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
        ],
        "listeners"=> [
            "Illuminate\Auth\Events\Login"=> [
                "20"=> "\\Zento\\WebShoppingCart\\Event\\Listener\\AuthLogin"
            ]
        ],
        "depends"=> [
            "Zento_Catalog",
            "Zento_Customer",
            "Zento_ShoppingCart"
        ]
    ]
];