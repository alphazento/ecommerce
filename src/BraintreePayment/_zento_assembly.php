<?php
return [
    "Zento_BraintreePayment" => [
        "version" => "0.0.1",
        "vue_component" => true,
        "commands" => [],
        "providers" => [
            "\\Zento\\BraintreePayment\\Providers\\Plugin",
        ],
        "depends" => ["Zento_PaymentGateway"],
    ],
];
