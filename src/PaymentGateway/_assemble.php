<?php
return [
    "Zento_PaymentGateway"=> [
        "version"=> "0.0.2",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\PaymentGateway\\Providers\\Entry"
        ],
        "depends"=> [
            "Zento_Backend"
        ]
    ]
];