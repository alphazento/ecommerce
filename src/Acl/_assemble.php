<?php
return [
    "Zento_Acl"=>[
        "version" => "0.0.1",
        "commands" => [
            "\\Zento\\Acl\\Console\\Commands\\SyncRoute",
            "\\Zento\\Acl\\Console\\Commands\\AddAdministrator",
            "\\Zento\\Acl\\Console\\Commands\\EnableAdministrator",
            "\\Zento\\Acl\\Console\\Commands\\DisableAdministrator",
            "\\Zento\\Acl\\Console\\Commands\\AdministratorPassword"
        ],
        "providers" => [
            "\\Zento\\Acl\\Providers\\Entry"
        ],
        "listeners"=>  [
        ],
        "middlewaregroup"=> [
           
        ],
        "depends"=> [
            "Zento_Passport",
            "Zento_Backend",
            "Zento_Customer"
        ]
    ]
];