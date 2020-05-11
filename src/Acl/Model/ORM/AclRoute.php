<?php

namespace Zento\Acl\Model\ORM;

use Illuminate\Routing\Route;

class AclRoute extends AclBaseModel
{
    private $_route;
    protected $fillable = [
        'scope',
        'catalog',
        'method',
        'uri',
        'removed',
        'active',
    ];

    protected function getRoute($method)
    {
        if (!$this->_route) {
            $this->_route = new Route($method, $this->uri, []);
        } else {
            if (!in_array($method, $this->_route->methods)) {
                $this->_route->methods[] = $method;
            }
        }
        return $this->_route;
    }

    public function test(\Illuminate\Http\Request $request)
    {
        if ($this->method == '*') {
            if ($this->uri == '*') {
                return true;
            }
            $this->method = $request->method();
        }
        return $this->getRoute(strtoupper($this->method))->matches($request);
    }

    public function inWhiteList($userId)
    {
        return AclWhiteList::where('user_id', $userId)->where('route_id', $this->id)->exists();
    }

    public function inBlackList($userId)
    {
        return AclBlackList::where('user_id', $userId)->where('route_id', $this->id)->exists();
    }

    public function inRolesRoutes($userId)
    {
        $roleUserTable = with(new AclRoleUser)->getTable();
        $roleRouteTable = with(new AclRoleRoute)->getTable();
        return AclRoleRoute::join(
            $roleUserTable,
            sprintf('%s.role_id', $roleUserTable), '=', sprintf('%s.role_id', $roleRouteTable)
        )
            ->where('route_id', $this->id)
            ->where('user_id', $userId)
            ->exists();
    }
}
