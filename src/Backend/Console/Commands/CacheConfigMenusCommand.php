<?php
/**
 *
 * @category   Framework support
 * @package    Backend
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Backend\Console\Commands;

use Artisan;
use Zento\Kernel\Facades\PackageManager;

class CacheConfigMenusCommand extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zento:admin:build:configmenus';

    protected $description = "";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
    }
}
