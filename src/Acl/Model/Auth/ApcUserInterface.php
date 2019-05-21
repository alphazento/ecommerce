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

interface ApcUserInterface
{
    public function permissions();

    public function permissionwhitelist();

    public function permissionblacklist();

    public function groups();
}
