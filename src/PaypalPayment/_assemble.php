<?php
return [
    "Zento_PaypalPayment"=> [
        "version"=> "0.0.1",
        "vue_component" => true,
        "commands"=> [],
        "providers"=> [
            "\\Zento\\PaypalPayment\\Providers\\Entry"
        ],
        "depends"=> ["Zento_PaymentGateway"]
    ]
];