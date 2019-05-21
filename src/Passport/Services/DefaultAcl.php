<?php
namespace Zento\Passport\Services;

/** do nothing */
class DefaultAcl implements AclInterface{
    public function checkRequest(\Illuminate\Http\Request $request) {
        return true;
    }
    public function checkRoute($uri, $method = 'get') {
        return true;
    }
}
