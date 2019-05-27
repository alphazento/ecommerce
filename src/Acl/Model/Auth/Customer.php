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

class Customer extends \Zento\Customer\Model\ORM\Customer implements AclUserInterface
{
    use TraitPermission;

    static $scope = \Zento\Acl\Consts::FRONTEND_SCOPE;

    public function acl($request) {
        // not check
    }
}
