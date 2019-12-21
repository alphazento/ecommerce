<?php

namespace Zento\Passport;

use Auth;
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

    public static function issueTokenWithouPasswordInPasswordGrantType(ServerRequestInterface $request, $email = null, $issuer) {
        // $userProvider = Auth::createUserProvider(Config::get('auth.guards.api.provider'));
        $model = Config::get('auth.providers.users.model');
        $localUser = (new $model)->findForPassport($email);
        if (!$localUser) {
            return false;
        }

        $oldPassword = $localUser->password;
        $parsedBody = $request->getParsedBody();
        $configs = [];
        if (!isset($parsedBody['client_id'])) {
            $configs = config(Consts::CONFIG_KEY_PASSPORT_DEFAULT_CLIENT);
        }
        $email = $email ?? $parsedBody['username'];
        $email = $email ?? $parsedBody['email'];
        $configs = $configs ?? [];
        $configs['username'] = $email;
        $configs['password'] = $localUser->applyRandomPassword();

        $request = $request->withParsedBody(array_merge($configs, $parsedBody));
        $issuedToken = $issuer->issueToken($request);
        $localUser->password = $oldPassword;
        $localUser->update();
        return $issuedToken;
    }
}
