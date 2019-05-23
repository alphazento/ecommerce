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

use Zento\Acl\Model\AdminGroup;

/**
 * Guest user can get gust group permission
 */
class GuestUser implements AclUserInterface
{
    static $scope = \Zento\Acl\Consts::GUEST_SCOPE;

    public $_groups = null;
    public function permissionwhitelist() {
        return null;
    }

    public function permissionblacklist() {
        return null;
    }

    public function permissions() {
        return null;
    }

    public function groups() {
        if (!$this->_groups) {
            $this->_groups = AdminGroup::where('name', '=', 'guest')->get();
        }
        return $this->_groups;
    }

    public function __get($key) {
        switch($key) {
            case 'permissionwhitelist':
            case 'permissionblacklist':
                return null;
            case 'groups':
                return $this->groups();
        }
        return null;
    }
}
