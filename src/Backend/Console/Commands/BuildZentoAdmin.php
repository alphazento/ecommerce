<?php
/**
 *
 * @category   Framework support
 * @package    Zento
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Backend\Console\Commands;

use Zento\Kernel\Facades\PackageManager;

class BuildZentoAdmin extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:zentoadmin {--force}';

    protected $description = "Build zento store admin app.";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->build();
    }

    public function build() {
        if ($forceBuild = $this->option('force')) {
            $zentoStoreFolder = PackageManager::packagePath('Zento_Backend',['zentoadmin']);
            exec(sprintf('cd %s && yarn build', $zentoStoreFolder));
        }

        $buildFolder = PackageManager::packagePath('Zento_Backend', ['zentoadmin', 'build']);
        $viewsPath = PackageManager::packageViewsPath('Zento_Backend');
        $builtIndexFile = $buildFolder . '/index.html'; 
        copy($builtIndexFile, $viewsPath . '/app.blade.php');
        $this->call('vendor:publish', ['--tag' => 'react-zentoadmin', '--force' => '']);
    }
}
