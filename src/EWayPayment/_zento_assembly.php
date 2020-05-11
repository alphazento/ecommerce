<?php
return [
    "Zento_EWayPayment" => [
        "version" => "0.0.1",
        "commands" => [],
        "providers" => [
            "\\Zento\\EWayPayment\\Providers\\Plugin",
        ],
        "depends" => [
            "Zento_PaymentGateway",
            "Zento_Backend",
        ],
    ],
];
