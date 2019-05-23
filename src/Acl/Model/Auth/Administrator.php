<?php
 /**
  *
  * @category   Framework support
  * @package    Base
  * @copyright
  * @license
  * @author      Yongcheng Chen yongcheng.chen@live.com
  */

namespace Zento\Acl\Model\Auth\Backend;

class Administrator extends \Zento\Backend\Model\ORM\Administrator implements AclUserInterface
{
    static $scope = \Zento\Acl\Consts::ADMIN_SCOPE;
    use TraitPermission;
}
