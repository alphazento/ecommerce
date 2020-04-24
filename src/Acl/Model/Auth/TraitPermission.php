<?php
 /**
  *
  * @category   Framework support
  * @package    Base
  * @copyright
  * @license
  * @author      Yongcheng Chen yongcheng.chen@live.com
  */

namespace Zento\Acl\Model\Auth;

use Zento\Acl\Model\ORM\AclRoute;
use Zento\Acl\Model\ORM\AclWhiteList;
use Zento\Acl\Model\ORM\AclBlackList;
use Zento\Acl\Model\ORM\AclRole;
use Zento\Acl\Model\ORM\AclRoleUser;

trait TraitPermission
{
    private $_routes;
    public function whiteRoutes() {
        return $this->hasManyThrough(AclRoute::class, AclWhiteList::class,
            'user_id',
            'id',
            'id',
            'route_id'
        )->where(with(new AclWhiteList)->getTable() . '.scope', '=', static::$scope);
    }

    public function blackRoutes() {
        return $this->hasManyThrough(AclRoute::class, AclBlackList::class,
            'user_id',
            'id',
            'id',
            'route_id'
        )->where(with(new AclBlackList)->getTable() . '.scope', '=', static::$scope);
    }

    public function roles() {
        return $this->hasManyThrough(AclRole::class, AclRoleUser::class,
            'user_id',
            'id',
            'id',
            'role_id'
        )->where(with(new AclRoleUser)->getTable() . '.scope', '=', static::$scope);
    }

    public function routes() {
        if (!$this->_routes) {
            $this->_routes = [];
            foreach($this->roles ?? [] as $role) {
                foreach($role->routes ?? [] as $item) {
                    if (!$this->objectInArray($item, $this->_routes, 'id')) {
                        $this->_routes[] = $item;
                    }
                }
            }
        }
        return $this->_routes;
    }

    private function objectInArray($needdle, &$array, $key) {
        foreach($array ??[] as $item) {
            if ($needdle[$key] == $item[$key]) {
                return true;
            }
        }
        return false;
    }
}
