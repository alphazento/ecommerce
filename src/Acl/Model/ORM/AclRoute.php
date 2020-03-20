<?php

namespace Zento\Acl\Model\ORM;

use Illuminate\Routing\Route;

class AclRoute extends AclBaseModel
{
    private $_route;
    protected $fillable = [
        'scope',
        'method',
        'uri',
        'removed',
        'active'
    ];
    protected function getRoute($method) {
        if (!$this->_route) {
            $this->_route = new Route($method, $this->uri, []);
        } else {
            if (!in_array($method, $this->_route->methods)) {
                $this->_route->methods[] = $method;
            }
        }
        return $this->_route;
    }

    public function test(\Illuminate\Http\Request $request) {
        if ($this->method == '*') {
            if ($this->uri == '*') {
                return true;
            }
            $this->method = $request->method();
        }
        return $this->getRoute(strtoupper($this->method))->matches($request);
    }
}
