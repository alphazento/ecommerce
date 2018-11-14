<?php

namespace Zento\Passport\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;


class ZentoPassportController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        if (!isset($parsedBody['client_id'])) {
            // if (config('passport.client')) {
            //     $request = $request->withParsedBody(array_merge($parsedBody, config('passport.client')));
            // }
            $parsedBody['grant_type'] = 'password';
            $parsedBody['client_id'] = 2;
            $parsedBody['client_secret'] = 'tDCSIP4FHjF5UVaGN0ZwpW2LuPSCFw4WD4Wy5zti';
            $parsedBody['scope'] = '*';
            $request = $request->withParsedBody($parsedBody);
        }
        return parent::issueToken($request);
    }
}
