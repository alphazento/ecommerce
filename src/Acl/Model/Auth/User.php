<?php
 /**
  *
  * @category   Framework support
  * @package    Base
  * @copyright
  * @license
  * @author      Yongcheng Chen tony@tonercity.com.au
  */

namespace Zento\Acl\Model\Auth;
use Zento\Acl\Model\AdminPermissionItem;
use Zento\Acl\Model\AdminUserPermissionWhiteList;
use Zento\Acl\Model\AdminUserPermissionBlackList;
use Zento\Acl\Model\AdminGroup;
use Zento\Acl\Model\AdminGroupUser;

class User extends \Inkstation\Admin\Model\Auth\User implements ApcUserInterface
{
    private $_permissions;
    public function permissionwhitelist() {
        return $this->hasManyThrough(AdminPermissionItem::class, AdminUserPermissionWhiteList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function permissionblacklist() {
        return $this->hasManyThrough(AdminPermissionItem::class, AdminUserPermissionBlackList::class,
            'user_id',
            'id',
            'id',
            'item_id'
        );
    }

    public function groups() {
        return $this->hasManyThrough(AdminGroup::class, AdminGroupUser::class,
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
