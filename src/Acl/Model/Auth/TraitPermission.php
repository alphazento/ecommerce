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
    private $_permissions;
    public function permissionwhitelist() {
        return $this->hasManyThrough(AclRoute::class, AclWhiteList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        )->where(with(new AclWhiteList)->getTable() . '.scope', '=', static::$scope);
    }

    public function permissionblacklist() {
        return $this->hasManyThrough(AclRoute::class, AclBlackList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        )->where(with(new AclBlackList)->getTable() . '.scope', '=', static::$scope);
    }

    public function groups() {
        return $this->hasManyThrough(AclRole::class, AclRoleUser::class,
            'user_id',
            'id',
            'id',
            'group_id'
        )->where(with(new AclRoleUser)->getTable() . '.scope', '=', static::$scope);
    }

    public function permissions() {
        if (!$this->_permissions) {
            $this->_permissions = [];
            foreach($this->groups ?? [] as $group) {
                foreach($group->permissions ?? [] as $item) {
                    if (!$this->objectInArray($item, $this->_permissions, 'id')) {
                        $this->_permissions[] = $item;
                    }
                }
            }
        }
        return $this->_permissions;
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
