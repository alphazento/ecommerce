<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\BladeTheme\Console\Commands;

use PackageManager;
use Illuminate\Support\Str;

class PrepareVueTheme extends \Zento\Kernel\PackageManager\Console\Commands\Base
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vuetheme:prepare';
    protected $description = 'prepare vue theme';

    protected $aliases = [];
    protected $mix = [];
    protected $mixDepress = [];
    protected $components = [];
    protected $componentJsonFiles = [];

    protected $themeName = '';

    protected $mergedPackages = [];

    public function handle() {
        $this->themeName = 'Zento_VueDesktopTheme';
        $this->mergeVueComponentPackageConfig();
        $this->mergeThemePackageConfig($this->themeName);
        $this->genWebpackMixJs();
        $this->genRegisterComponentProdFile();
        $this->genRegisterComponentDevFile();
        
        $this->info('Please run command to compile:');
        // $this->warn(sprintf('    npm run dev "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run prod "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run watch "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run hot "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 

        $this->warn(sprintf('    npm run dev "\'--theme=%s\'"', $this->themeName)); 
        $this->warn(sprintf('    npm run prod "\'--theme=%s\'"', $this->themeName)); 
        $this->warn(sprintf('    npm run watch "\'--theme=%s\'"', $this->themeName)); 
        $this->warn(sprintf('    npm run hot "\'--theme=%s\'"', $this->themeName)); 
    }

    protected function mergeVueComponentPackageConfig() {
        $packageConfigs = PackageManager::loadPackagesConfigs();
        foreach($packageConfigs ?? [] as $name => $packageConfig) {
            if (!isset($this->mergedPackages[$name])) {
                $assembly = PackageManager::assembly($name);
                if (!empty($assembly) && ($assembly['vue_component'] ?? false)) {
                    $this->_mergeThemePackageConfig($name, $assembly, $packageConfig);
                }
            }
        }
    }

    protected function mergeThemePackageConfig($packageName) {
        if ($packageConfig = PackageManager::getPackageConfig($packageName)) {
            if ($packageConfig['enabled'] ?? false) {
                if ($assembly = PackageManager::assembly($packageName)) {
                    if (isset($assembly['theme'])) {
                        if (is_string($assembly['theme'])) {
                            $this->mergeThemePackageConfig($assembly['theme']);
                        }
                        $this->_mergeThemePackageConfig($packageName, $assembly, $packageConfig);
                        return true;
                    }
                }
            }
        }
        return false;
    }

    protected function _mergeThemePackageConfig($packageName, $assembly, $packageConfig) {
        $this->mergedPackages['packageName'] = true;
        if ($file = PackageManager::packagePath($packageName, ['resources', 'vue'])) {
            if (file_exists($file)) {
                $aliasValue =  substr(PackageManager::packagePath($packageName, ['resources', 'vue']), strlen(base_path()) + 1);
                $this->aliases[$packageName] = $aliasValue;
            }

            if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_mix_.js'])) {
                if (file_exists($file)) {
                    $content = file_get_contents($file);
                    $aliasName = '@' . $packageName;
                    $this->mix[$packageName] = str_replace($aliasName, $aliasValue, $content);
                }
            } 
        }

        

        if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_mix_depress.json'])) {
            if (file_exists($file)) {
                $this->mixDepress = array_merge($this->mixDepress, json_decode(file_get_contents($file), true));
             }
        }

        if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_components.json'])) {
            if (file_exists($file)) {
                $this->componentJsonFiles[$packageName] = $file;
                $this->components[$packageName] = json_decode(file_get_contents($file), true);
            }
        }

        if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_components.js'])) {
            if (file_exists($file)) {
                $this->componentJsonFiles[$packageName] = $file;
            }
        }
    }

    protected function genWebpackMixJs() {
        $contents = [];
        foreach($this->mix as $packageName => $content) {
            if ($packageName !== 'Zento_BladeTheme') {
                foreach($this->aliases as $name => $value) {
                    $contents[] = sprintf('mix.alias("@%s", "%s");', $name, $value);
                }
            }
            if (!in_array($packageName, $this->mixDepress)) {
                $contents[] = $content;
            }
        }
        $contents[] = 'mix.mergeManifest();';
        file_put_contents(base_path(sprintf('webpack.mix.%s.js', $this->themeName)), implode(PHP_EOL, $contents));
    }

    protected function genRegisterComponentProdFile() {
        $contents = ['var Vue = window.Vue;'];
        foreach($this->components as $themeName => $components) {
            $alias = '@' . $themeName;
            $jsFolder = strtolower($themeName);
            foreach($components as $name => $file) {
                if (isset($contents[$name])) {
                    $this->warn(sprintf('Vue component [%s] has been defined in other module', $name));
                    $this->warn(sprintf('Here is the previous defination', $contents[$name]));
                } 
                $lines = [];
                $variableName = sprintf('Dynamic%sComponent', Str::studly($name));
                $lines[] = sprintf('const %s= ()=> import("%s/%s" /* webpackChunkName:"%s/js/cmps/%s" */);', 
                    $variableName,
                    $alias,
                    $file,
                    $jsFolder,
                    Str::slug($name)
                );
                $lines[] = sprintf('Vue.component("%s", %s);', $name, $variableName);
                $contents[$name] = implode(PHP_EOL, $lines);
            }
        }
        if ($file = PackageManager::packagePath($this->themeName, ['resources', 'vue', '._app.prod.js'])) {
            file_put_contents($file, implode(PHP_EOL, $contents));
        }
    }

    protected function genRegisterComponentDevFile() {
        $contents = [];
        $imports = ['var Vue = window.Vue;'];
        foreach($this->componentJsonFiles as $themeName => $jsFile) {
            $configName = $themeName . '_Configs';
            $imports[] = sprintf('import %s from "@%s/_components.js"', $configName, $themeName);
            $contents[] = sprintf('
for (const [key, value] of Object.entries(%s)) {
    Vue.component(
        key,
        () => import(`@%s/${value}` /* webpackChunkName:"vue-dev-watch/%s" */ )
    );
}', $configName, $themeName, Str::slug($themeName));
        }
        $imports[] = '';

        if ($file = PackageManager::packagePath($this->themeName, ['resources', 'vue', '._app.dev.js'])) {
            file_put_contents($file, implode(PHP_EOL, $imports));
            file_put_contents($file, implode(PHP_EOL, $contents), FILE_APPEND);
        }
    }
}
