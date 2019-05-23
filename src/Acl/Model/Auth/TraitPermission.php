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

use Zento\Acl\Model\ORM\AclPermissionItem;
use Zento\Acl\Model\ORM\AclUserPermissionWhiteList;
use Zento\Acl\Model\ORM\AclUserPermissionBlackList;
use Zento\Acl\Model\ORM\AclUserGroup;
use Zento\Acl\Model\ORM\AclGroupUserList;

trait TraitPermission
{
    private $_permissions;
    public function permissionwhitelist() {
        return $this->hasManyThrough(AclPermissionItem::class, AclUserPermissionWhiteList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        )->where(with(new AclUserPermissionWhiteList)->getTable() . '.scope', '=', static::$scope);
    }

    public function permissionblacklist() {
        return $this->hasManyThrough(AclPermissionItem::class, AclUserPermissionBlackList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        )->where(with(new AclUserPermissionBlackList)->getTable() . '.scope', '=', static::$scope);
    }

    public function groups() {
        return $this->hasManyThrough(AclUserGroup::class, AclGroupUserList::class,
            'user_id',
            'id',
            'id',
            'group_id'
        )->where(with(new AclGroupUserList)->getTable() . '.scope', '=', static::$scope);
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
