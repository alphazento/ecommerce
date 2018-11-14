<?php

namespace Zento\Passport\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;

class ZentoPassportController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        return parent::issueToken($request);
    }
}
