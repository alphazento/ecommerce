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

use Zento\Acl\Model\ORM\AclRole;

/**
 * Guest user can get gust group permission
 */
class GuestUser implements AclUserInterface
{
    static $scope = \Zento\Acl\Consts::GUEST_SCOPE;

    public $_roles = null;
    public function whiteRoutes() {
        return null;
    }

    public function blackRoutes() {
        return null;
    }

    public function routes() {
        return null;
    }

    public function roles() {
        if (!$this->_roles) {
            $this->_roles = AclRole::where('name', '=', 'guest')->get();
        }
        return $this->_roles;
    }

    public function __get($key) {
        switch($key) {
            case 'whiteRoutes':
            case 'blackRoutes':
                return null;
            case 'roles':
                return $this->roles();
        }
        return null;
    }
}
