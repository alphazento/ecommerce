<?php
return [
    "Zento_SnsConnect"=> [
        "version"=> "0.0.1",
        "vue_component" => true,
        "commands"=> [],
        "providers"=> [
            "\\Zento\\SnsConnect\\Provider"
        ],
        "depends"=> [
            'Zento_BladeTheme'
        ]
    ]
];