<?php
return [
    "Zento_EWayPayment"=> [
        "version"=> "0.0.1",
        "commands"=> [],
        "providers"=> [
            "\\Zento\\EWayPayment\\Providers\\Entry"
        ],
        "depends"=> ["Zento_PaymentGateway"]
    ]
];