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

class Administrator extends \Zento\Backend\Model\ORM\Administrator implements AclUserInterface
{
    use TraitPermission;
    static $scope = \Zento\Acl\Consts::BACKEND_SCOPE;
}
