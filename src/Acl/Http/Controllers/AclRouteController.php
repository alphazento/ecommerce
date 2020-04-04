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

    /**
     * Retrieves all routes in a scope
     * @authenticated
     * @group ACL Management
     * @urlParam scope required options of ['administrator', 'customer']. Indicate backend or frontend. Example:administrator
     * @queryParam from options of ['role', 'user', '', 'routes']
     * @response {"success":true,"code":200,"locale":"en","message":"",
     * "data":[
     * 'routes details',
     * 'role1 details'
     * ]}
     */
    public function routes() {
        $collection = AclRoute::where('active', 1)
            ->where('deleted', 0)
            ->whereIn('scope', $this->getScopes())
            ->orderBy('scope')
            ->orderBy('acl')
            ->orderBy('method');
        if ($from = Request::get('from')) {
            if (in_array($from, ['role', 'user'])) {
                $collection->whereNotIn('acl', ['false']);
            }
        }
        return $this->withData($collection->get());
    }
}
