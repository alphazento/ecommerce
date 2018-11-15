<?php

namespace Zento\Passport\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;


class ZentoPassportController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            if ($configs = config('passport.defaultclient')) {
                $request = $request->withParsedBody(array_merge($configs, $parsedBody));
            }
        }
        return parent::issueToken($request);
    }
}
