<?php

namespace Zento\Acl\Services;

use Store;
use Auth;
use Request;
use ShareBucket;

use Zento\Acl\Model\Auth\GuestUser;
use Zento\Acl\Model\Auth\AclUserInterface;

class Acl implements AclInterface {
    protected $user;
    protected function getUser() {
        if (!$this->user) {
            $this->user = Auth::guard('api')->user() ?? new GuestUser();
        }
        return $this->user;
    }

    /**
     * check by request
     */
    public function checkRequest(\Illuminate\Http\Request $request, $user = null) {
        if (ShareBucket::get('ignore_acl_check')) {
            return true;
        }

        $user = $user ?? $this->getUser();
        if ($this->inBlackList($request, $user)) {
            return false;
        }

        if ($this->inWhiteList($request, $user)) {
            return true;
        }

        if ($this->matchGroupPermission($request, $user)) {
            return true;
        }
        return false;
    }

    public function checkRoute($uri, $method = 'get', $user = null) {
        return $this->checkRequest(Request::create($uri, strtoupper($method)), $user);
    }

    protected function inWhiteList(\Illuminate\Http\Request $request, AclUserInterface $user) {
        foreach ($user->permissionwhitelist ?? [] as $permission) {
            if ($permission && $permission->test($request)) {
                return true;
            }
        }
        return false;
    }

    protected function inBlackList(\Illuminate\Http\Request $request, AclUserInterface $user) {
        foreach ($user->permissionblacklist ?? [] as $permission) {
            if ($permission && $permission->test($request)) {
                return true;
            }
        }
        return false;
    }

    protected function matchGroupPermission(\Illuminate\Http\Request $request, AclUserInterface $user) {
        foreach($user->groups ?? [] as $group) {
            foreach ($group->permissions ?? [] as $permission) {
                if ($permission && $permission->test($request)) {
                    return true;
                }
            }
        }

        return false;
    }


    public function grant($uri, $method, $user) {

    }

    public function flush($uri, $user) {

    }

    /**
     * add to user's white list
     *
     * @param string $uri
     * @param string $method
     * @param $user
     * @return void
     */
    public function addToWhiteList($uri, $method, $user) {

    }

    /**
     * add to user's black list
     *
     * @param string $uri
     * @param string $method
     * @param $user
     * @return void
     */
    public function addToBlackList($uri, $method, $user) {

    }
}
