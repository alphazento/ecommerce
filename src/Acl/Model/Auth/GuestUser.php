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

/**
 * Guest user can get gust group permission
 */
class GuestUser implements AclUserInterface
{
    static $scope = \Zento\Acl\Consts::BOTH_SCOPE;

    public $_roles = null;
    public function whiteRoutes()
    {
        return null;
    }

    public function blackRoutes()
    {
        return null;
    }

    public function routes()
    {
        return null;
    }

    public function roles()
    {
        return null;
    }

    public function __get($key)
    {
        return null;
    }
}
