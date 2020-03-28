<?php
/**
 *
 * @copyright
 * @license
 * @author      Yongcheng Chen yongcheng.chen@live.com
 */

namespace Zento\Acl\DocBlock;

use Psy\Util\Docblock;
use ReflectionClass;
use Zento\Acl\Consts;
use Zento\Acl\Model\ORM\AclRoute;
use Illuminate\Routing\Route;

class RouteAnalyzer
{
    protected $reflection_cache = [];
    protected $method_docs_cache = [];
    public function analyze(Route $route) {
        $middlewares = $route->action['middleware'] ?? [];
        if (is_string($middlewares)) {
            $middlewares = [$middlewares];
        }
        if (!in_array('auth:api', $middlewares)) {
            return false;
        }

        $dockBlock = $this->retrieveRouteDockBlock($route);
        $tags = $dockBlock->tags;
        $acl = false;
        $scope = Consts::FRONTEND_SCOPE;
        
        $parts = explode('/', $route->uri);
        if (count($parts) >= 3) {
            if ($parts[0] == 'api' && $parts[2] == 'admin') {
                $scope = Consts::BACKEND_SCOPE;
                //admin default will need acl, if there's a tag 'no_acl', it will be false
                $acl = !isset($tags['no-acl']);
            }
        } else {
            //admin default will not need acl, if there's a tag 'acl', it will be true
            $acl = isset($tags['acl']);
        }
        
        $group = $tags['group'][0] ?? 'General';
        $description = $tags['desc'] ?? '';
        return compact('scope', 'group', 'description', 'acl');
    }

    protected function retrieveRouteDockBlock(Route $route) {
        list($className, $methodName) = $this->getClassAndMethodNames($route);
        $cacheKey = sprintf('%s::%s', $className, $methodName);
        if (!isset($this->method_docs_cache[$cacheKey])) {
            if (!isset($this->reflection_cache[$cacheKey])) {
                $this->reflection_cache[$cacheKey] = new ReflectionClass($className);
            }
            $reflection = $this->reflection_cache[$cacheKey];
            if (! $reflection->hasMethod($methodName)) {
                throw new \Exception(
                    sprintf('Error while analyzing docblock for route: Class %s does not contain method %s',
                    $className, $methodName));
            }
            $methodBlock = new DocBlock($reflection->getMethod($methodName));
            $this->method_docs_cache[$cacheKey] = $methodBlock;
            return $methodBlock;
        } else {
            return $this->method_docs_cache[$cacheKey];
        }
    }
    
    protected function getClassAndMethodNames(Route $route)
    {
        $action = $route->getAction();

        if ($action['uses'] ?? false) {
            if (is_array($action['uses'])) {
                return $action['uses'];
            } elseif (is_string($action['uses'])) {
                return explode('@', $action['uses']);
            }
        }
        if (array_key_exists(0, $action) && array_key_exists(1, $action)) {
            return [
                0 => $action[0],
                1 => $action[1],
            ];
        }
    }
}
