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
use Zento\Acl\Model\PermissionItem;
use Zento\Acl\Model\UserPermissionWhiteList;
use Zento\Acl\Model\UserPermissionBlackList;
use Zento\Acl\Model\UserGroup;
use Zento\Acl\Model\GroupUserList;

class User extends \Zento\Backend\Model\ORM\Administrator implements AclUserInterface
{
    private $_permissions;
    public function permissionwhitelist() {
        return $this->hasManyThrough(PermissionItem::class, UserPermissionWhiteList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function permissionblacklist() {
        return $this->hasManyThrough(PermissionItem::class, UserPermissionBlackList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function groups() {
        return $this->hasManyThrough(UserGroup::class, GroupUserList::class,
            'user_id',
            'id',
            'id',
            'group_id'
        );
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
