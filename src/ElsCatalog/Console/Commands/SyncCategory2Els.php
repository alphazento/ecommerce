<?php
/**
 *
 * @category   Framework support
 * @package    M2Data
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\ElsCatalog\Console\Commands;

use Artisan;

class SyncCategory2Els extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'els:sync {type : category or product}';

    protected $description = "sync category from mysql to elasticsearch";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->argument('type');
        switch($type) {
            case 'category':
                $syncer = new \Zento\ElsCatalog\Processor\CategorySync();
                $syncer->sync();
                break;
            case 'product': 
                $syncer = new \Zento\ElsCatalog\Processor\ProductSync();
                $syncer->sync();
                break;
            default:
                echo 'Not support type: ' . $type . PHP_EOL;
                break;
        }
        
    }
}
