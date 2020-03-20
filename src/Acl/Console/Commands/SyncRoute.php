<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\Console\Commands;

use Zento\Acl\Consts;
use Zento\Acl\Model\ORM\AclRoute;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncRoute extends \Illuminate\Foundation\Console\RouteListCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:sync';

    protected $description = 'convert api route to permission';

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
        if (empty($routes = $this->getRoutes())) {
            return $this->error("Your application doesn't have any routes matching the given criteria.");
        }
        $routes = collect($routes)->filter(function($item) {
            if (Str::startsWith($item['uri'], 'api/') || Str::startsWith($item['uri'], '/api/')) {
                return true;
            }
        })->all();

        $this->convertToPermissionItems($routes);
        $this->displayRoutes($routes);
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected function getRouteInformation(Route $route)
    {
        $info = parent::getRouteInformation($route);
        $info['catalog'] = $route->catalog();
        $info['scope'] = $route->scope();
        return $info;
    }

    protected function getColumns() {
        $columns = parent::getColumns();
        $columns[] = 'catalog';
        $columns[] = 'scope';
        return $columns;
    }


    protected function needPermission(array $route) {
        if ($middleware = ($route['middleware'] ?? false)) {
            return in_array('auth:api', explode(',', $middleware));
        }
        return false;
    }

    protected function convertToPermissionItems(array $routes)
    {
        $ids = [1];
        $item = null;
        foreach($routes as $route) {
            if (!$this->needPermission($route)){
                continue;
            }
            $methods = explode('|', $route['method']);
            foreach($methods as $method) {
                if ($method != 'HEAD') {
                    $item = AclRoute::where('method', $method)->where('uri', $route['uri'])->first();
                    if (!$item) {
                        $item = new AclRoute([
                            'method' => $method,
                            'uri' => $route['uri'],
                            'removed' => 0,
                            'active' => 1
                        ]);
                    }
                    if ($item) {
                        $item->name = $route['name'];
                        $item->catalog = $route['catalog'];
                        $item->scope = $route['scope'];
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
