<?php
/**
 *
 * @category   Framework support
 * @package    Zento
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\ReactApp\Console\Commands;

use Zento\Kernel\Facades\PackageManager;

class BuildApp extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:storefront {--force}';

    protected $description = "Build zento store front app.";

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
            $zentoStoreFolder = PackageManager::packagePath('Zento_ReactApp',['zentostore']);
            exec(sprintf('cd %s && yarn build', $zentoStoreFolder));
        }

        $buildFolder = PackageManager::packagePath('Zento_ReactApp', ['zentostore', 'build']);
        $viewsPath = PackageManager::packageViewsPath('Zento_ReactApp');
        $builtIndexFile = $buildFolder . '/index.html'; 
        copy($builtIndexFile, $viewsPath . '/app.blade.php');
        $this->call('vendor:publish', ['--tag' => 'react-storefront', '--force' => '']);
    }
}
