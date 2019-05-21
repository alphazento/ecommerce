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

interface AclUserInterface
{
    public function permissions();

    public function permissionwhitelist();

    public function permissionblacklist();

    public function groups();
}
