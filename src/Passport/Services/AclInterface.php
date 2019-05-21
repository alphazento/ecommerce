<?php

namespace Zento\Passport\Services;

use Request;
use Store;

/** do nothing */
interface AclInterface {
    public function checkRequest(\Illuminate\Http\Request $request);
    public function checkRoute($uri, $method = 'get');
}
