<?php
return [
    "Zento_PaymentGateway"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\PaymentGateway\\Providers\\Plugin"
        ],
        "depends"=> [
            "Zento_Backend"
        ]
    ]
];