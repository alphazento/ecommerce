<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen tony@tonercity.com.au
 */

namespace Zento\Acl\Console\Commands;

use Illuminate\Routing\Router;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zento\Acl\Model\AdminPermissionItem;

class SyncRoute extends \Illuminate\Foundation\Console\RouteListCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apc:syncroute';

    protected $description = 'Turn api route as permission';

    public static function register($serviceProvider, $appContainer = null) {
        $class = static::class;
        $name = md5($class);
        $appContainer = $appContainer ?? app();
        $appContainer->singleton($name, function ($app) use($class) {
            return $app[$class];
        });
        $serviceProvider->commands($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $method = method_exists($this, 'handle') ? 'handle' : 'fire';
        return $this->laravel->call([$this, $method]);
    }


    public function option($key=null) {
        if ($key == 'path') {
            // return ltrim('/');
        }
        return false;
    }

    public function handle() {
        if (empty($this->routes)) {
            return $this->error("Your application doesn't have any routes.");
        }

        if (empty($routes = $this->getRoutes())) {
            return $this->error("Your application doesn't have any routes matching the given criteria.");
        }

        $this->convertToPermissionItems($routes);
        $this->displayRoutes($routes);
    }

    protected function convertToPermissionItems(array $routes)
    {
        $ids = [1];
        $item = null;
        foreach($routes as $route) {
            $methods = explode('|', $route['method']);
            foreach($methods as $method) {
                if ($method != 'HEAD') {
                    $item = AdminPermissionItem::where('method', $method)->where('uri', $route['uri'])->first();
                    if (!$item) {
                        $item = new AdminPermissionItem([
                            'method' => $method,
                            'uri' => $route['uri'],
                            'removed' => 0,
                            'active' => 1
                        ]);
                    }
                    if ($item) {
                        $names = explode(':', $route['name']);

                        $item->groupname = count($names) > 1 ? $names[0] : 'other';
                        $item->name = count($names) > 1 ? $names[1] : $names[0];
                        $item->removed = 0;
                        $item->save();
                        $ids[] = $item->id;
                    }
                }
            }
        }

        if ($item) {
            $item->getConnection()
                ->table($item->getTable())
                ->whereNotIn('id', $ids)
                ->update(['removed' => 1]);
        }
    }
}
