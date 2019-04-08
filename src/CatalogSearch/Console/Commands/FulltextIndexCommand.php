<?php

namespace Zento\CatalogSearch\Console\Commands;

use Zento\CatalogSearch\Model\ORM\FulltextData;

class FulltextReIndexCommand extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'index:fulltext';
        
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reindex fulltext for product search';

    //\Inkstation\SEO\Model\UrlGenerator
    private $urlgenerator;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->buildIndex();
    }

    private function buildIndex() {
    }
}
