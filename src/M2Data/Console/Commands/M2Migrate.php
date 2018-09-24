<?php
/**
 *
 * @category   Framework support
 * @package    M2Data
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\M2Data\Console\Commands;

use Artisan;
use Zento\Kernel\Facades\PackageManager;

class M2Migrate extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magento2:migrate';

    protected $description = "";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $seeder = new \Zento\M2Data\Seeders\CategorySeeder();
        // $seeder->run();

        $seeder = new \Zento\M2Data\Seeders\ProductSeeder();
        $seeder->run();
    }
}
