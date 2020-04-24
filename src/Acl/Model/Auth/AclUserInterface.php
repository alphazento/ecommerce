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
    public function routes();

    public function whiteRoutes();

    public function blackRoutes();

    public function roles();
}
