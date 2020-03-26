<?php

namespace Zento\Acl\Services;

use Auth;
use Store;
use Request;
use ShareBucket;

use Zento\Acl\Model\Auth\GuestUser;
use Zento\Acl\Model\Auth\AclUserInterface;
use Zento\Acl\Model\ORM\AclRoute;

class Acl implements AclInterface {
    protected function matchAclRoutes(\Illuminate\Http\Request $request) {
        if ($route = $request->route()) {
            return AclRoute::where('uri', $route->uri)
                ->whereIn('method', $route->methods)
                ->where('active', 1)
                ->first();
        }
        return null;
    }

    protected $userIsRoots = [];

    /**
     * check by request
     */
    public function checkRequest(\Illuminate\Http\Request $request, $user = null) {
        if ($route = $request->route()) {
            if (in_array($route->catalog, ['no-acl'])) {
                return true;
            }
        }
        
        if ($user = $user ?? $request->user) {
            if ($this->isRootUser($user)) {
                return true;
            }

            if ($route = $this->matchAclRoutes($request)) {
                if ($route->inBlackList($user->id)) {
                    return true;
                }
                if ($route->inBlackList($user->id)) {
                    return false;
                }
                if ($route->inRolesRoutes($user->id)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isRootUser($user) {
        if ($user) {
            if (isset($this->userIsRoots[$user->id])) {
                return true;
            }
            $exists = $user->roles()->where('name', 'root')->exists();
            $this->userIsRoots[$user->id] = $exists;
            return $exists;
        }
        return false;
    }

    public function checkRoute($uri, $method = 'get', $user = null) {
        return $this->checkRequest(Request::create($uri, strtoupper($method)), $user);
    }

    /**
     * admin pannel UX
     */
    public function allowUX($uiItem, $desc = null) {
        if ($this->isRootUser($user)) {
            return true;
        }

        if ($user = Auth::user()) {
            return true;
        }
        return false;
    }
}
