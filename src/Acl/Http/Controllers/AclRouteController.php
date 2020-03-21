<?php

namespace Zento\Acl\Http\Controllers;

use Auth;
use Route;
use Request;
use Illuminate\Support\Facades\Validator;
use Zento\Kernel\Http\Controllers\ApiBaseController;
use Zento\Acl\Model\Auth\Customer;
use Zento\Acl\Model\Auth\Administrator;
use Zento\Acl\Model\ORM\AclRole;
use Zento\Acl\Model\ORM\AclRoleUser;
use Zento\Acl\Model\ORM\AclRoute;
use Zento\Acl\Model\ORM\AclRoleRoute;
use Zento\Acl\Model\ORM\AclWhiteList;
use Zento\Acl\Model\ORM\AclBlackList;
use Zento\Acl\Consts;

class AclRouteController extends ApiBaseController
{
    use TraitHelper;

    public function routes() {
        return $this->withData(AclRoute::where('active', 1)->get());
    }
}
