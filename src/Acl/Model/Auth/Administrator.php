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

use Zento\Acl\Model\PermissionItem;
use Zento\Acl\Model\UserPermissionWhiteList;
use Zento\Acl\Model\UserPermissionBlackList;
use Zento\Acl\Model\UserGroup;
use Zento\Acl\Model\GroupUserList;

class User extends \Zento\Backend\Model\ORM\Administrator implements AclUserInterface
{
    use TraitPermission;
}
