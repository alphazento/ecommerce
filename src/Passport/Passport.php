<?php

namespace Zento\Passport;

use Config;
use Psr\Http\Message\ServerRequestInterface;

class Passport
{
    protected static $callbacks = [];

    public static function setPassportUserModel($modelClass) {
        Config::set('auth.providers.users.model', $modelClass);
    }

    public static function registerPostAuthcateHook(\Closure $callback) {
        self::$callbacks[] = $callback;
    }

    public function callPostAuthcateHooks($user, $request) {
        foreach(self::$callbacks as $callback) {
            $callback($user, $request);
        }
    }

    public static function issueTokenWithouPasswordInPasswordGrantType(ServerRequestInterface $request, $email = null) {
        $userProvider = Auth::createUserProvider(Config::get('auth.api.provider'));

        $localUser = $userProvider->findForPassport($email);
        if (!$localUser) {
            return false;
        }

        $oldPassword = $localUser->getPassword();
        $parsedBody = $request->getParsedBody();
        $configs = [];
        if (!isset($parsedBody['client_id'])) {
            $configs = config('passport.defaultclient');
        }
        $email = $email ?? $parsedBody['username'];
        $email = $email ?? $parsedBody['email'];
        $configs = $configs ?? [];
        $configs['username'] = $email;
        $configs['password'] = $localUser->applyRandomPassword();

        $request = $request->withParsedBody(array_merge($configs, $parsedBody));
        $issuedToken = $this->issueToken($request);
        $localUser->setPassword($oldPassword);
        return $issuedToken;
    }
}
