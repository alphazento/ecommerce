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
    protected $npmPackageInstalled = false;

    protected $themeType = 'frontstore';

    public function handle() {
        $packageConfigs = PackageManager::loadPackagesConfigs();
        foreach($packageConfigs ?? [] as $name => $packageConfig) {
            if ($assembly = PackageManager::assembly($name)) {
                if ($assembly['vuetheme_type'] ?? false) {
                    $this->themeType = $assembly['vuetheme_type'];
                    $this->handleThemePackage($name);
                }
            }
        }
    }

    protected function handleThemePackage($themeName) {
        $this->aliases = [];
        $this->mix = [];
        $this->mixDepress = [];
        $this->components = [];
        $this->componentJsonFiles = [];
        $this->mergedPackages = [];
        $this->themeName = $themeName;


        $this->mergeVueComponentPackageConfig();
        $this->mergeThemePackageConfig('Zento_BladeTheme');  //all vuetheme depends on this theme
        $this->mergeThemePackageConfig($themeName);
        $this->genWebpackMixJs();
        // $this->genRegisterComponentProdFile();
        $this->genRegisterComponentSupportFile();
        
        $this->info(sprintf('Theme package [%s] found:', $themeName));
        $this->info('   Please run command to compile:');
        // $this->warn(sprintf('    npm run dev "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run prod "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run watch "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 
        // $this->warn(sprintf('    npm run hot "\'--env.mixfile=webpack.mix.%s.js\'"', $this->themeName)); 

        $this->warn(sprintf('    npm run dev "\'--theme=%s\'"', $themeName)); 
        $this->warn(sprintf('    npm run prod "\'--theme=%s\'"', $themeName)); 
        $this->warn(sprintf('    npm run watch "\'--theme=%s\'"', $themeName)); 
        $this->warn(sprintf('    npm run hot "\'--theme=%s\'"', $themeName)); 
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
        $this->npmPackageInstalled = true;
        return $packageConfigs;
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
                    } else {
                        if ($assembly['vuetheme_type'] ?? false) {
                            $this->_mergeThemePackageConfig($packageName, $assembly, $packageConfig);
                            return true;
                        }
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
                $aliasValue = substr($file, strlen(base_path()) + 1);
                $this->aliases[$packageName] = $aliasValue;
                if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_mix_.js'])) {
                    if (file_exists($file)) {
                        $content = file_get_contents($file);
                        $aliasName = '@' . $packageName;
                        $this->mix[$packageName] = str_replace($aliasName, $aliasValue, $content);
                    }
                } 

                if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_mix_depress.json'])) {
                    if (file_exists($file)) {
                        $this->mixDepress = array_merge($this->mixDepress, json_decode(file_get_contents($file), true));
                    }
                }

                if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', sprintf('_%s.asm.js', $this->themeType)])) {
                    if (file_exists($file)) {
                        $this->componentJsonFiles[$packageName] = $file;
                    }
                }

                //install npm package
                if (!$this->npmPackageInstalled) {
                    if ($file = PackageManager::packagePath($packageName, ['resources', 'vue', '_npm.package.json'])) {
                        if (file_exists($file)) {
                            $exNpmPackages = json_decode(file_get_contents($file), true);
                            foreach($exNpmPackages as $npmPackage) {
                                $this->info(sprintf("install [%s] depends npm package %s", $packageName, $npmPackage));
                                exec(sprintf('cd %s && npm i %s',base_path(), $npmPackage));
                            }
                        }
                    }
                }
                
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

    // protected function genRegisterComponentProdFile() {
    //     $contents = ['var Vue = window.Vue;'];
    //     foreach($this->components as $themeName => $components) {
    //         $alias = '@' . $themeName;
    //         $jsFolder = strtolower($themeName);
    //         foreach($components as $name => $file) {
    //             if (isset($contents[$name])) {
    //                 $this->warn(sprintf('Vue component [%s] has been defined in other module', $name));
    //                 $this->warn(sprintf('Here is the previous defination', $contents[$name]));
    //             } 
    //             $lines = [];
    //             $variableName = sprintf('Dynamic%sComponent', Str::studly($name));
    //             $lines[] = sprintf('const %s= ()=> import("%s/%s" /* webpackChunkName:"%s/js/cmps/%s" */);', 
    //                 $variableName,
    //                 $alias,
    //                 $file,
    //                 $jsFolder,
    //                 Str::slug($name)
    //             );
    //             $lines[] = sprintf('Vue.component("%s", %s);', $name, $variableName);
    //             $contents[$name] = implode(PHP_EOL, $lines);
    //         }
    //     }
    //     if ($file = PackageManager::packagePath($this->themeName, ['resources', 'vue', '._app.prod.js'])) {
    //         file_put_contents($file, implode(PHP_EOL, $contents));
    //     }
    // }

    protected function genRegisterComponentSupportFile() {
        $contents = [];
        $imports = [
            'var Vue = window.Vue;',
            'var routes = [];'
        ];
        foreach($this->componentJsonFiles as $themeName => $jsFile) {
            $configName = $themeName . '_ASM';
            $imports[] = sprintf('import %s from "@%s/_%s.asm.js"', $configName, $themeName, $this->themeType);
            $contents[] = sprintf('
            if (%s.components !== undefined) { 
                for (const [key, value] of Object.entries(%s.components)) {
                    Vue.component(
                        key,
                        () => import(`@%s/${value}` /* webpackChunkName:"vue-dev-watch/%s" */ )
                    );
                }
            }', $configName, $configName, $themeName, Str::slug($themeName));
            $contents[] = sprintf('if (%s.routes) { routes = routes.concat(%s.routes); }', $configName, $configName);
        }

        $contents[] = 'export default { routes: routes }';
        $imports[] = '';

        if ($file = PackageManager::packagePath($this->themeName, ['resources', 'vue', '._app.support.js'])) {
            file_put_contents($file, implode(PHP_EOL, $imports));
            file_put_contents($file, implode(PHP_EOL, $contents), FILE_APPEND);
        }
    }
}
