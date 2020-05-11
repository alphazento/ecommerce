<?php

namespace Zento\Acl\Services;

use Request;

/** do nothing */
interface AclInterface
{
    public function checkRequest(\Illuminate\Http\Request $request, $user = null);
    public function checkRoute($uri, $method = 'get', $user = null);
}
