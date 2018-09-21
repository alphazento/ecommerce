<?php
return [
	'version'=>'0.0.4',
	'module'=>[
		'providers'=>[
            '\Zento\Catalog\Providers\Entry'
        ],
        'middlewares'=>[],
        'commands'=>[
            '\Zento\Catalog\Console\Commands\SearchCommand',
            '\Zento\Catalog\Console\Commands\FulltextReIndexCommand',
        ],
        'aliases'=>[
            'Category' => '\Zento\Catalog\Providers\Facades\Category',
            'PrinterCategory' => '\Zento\Catalog\Providers\Facades\PrinterCategory',
            'Product' => '\Zento\Catalog\Providers\Facades\Product',
        ],
	],
];
