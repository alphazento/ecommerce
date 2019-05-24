<?php

namespace Zento\Passport;

use ShareBucket;
use Psr\Http\Message\ServerRequestInterface;

class Passport
{
    // [
    //     'driver' => 'eloquent',
    //     'model' => \Zento\Passport\Model\User::class,
    // ]; 
    protected static $userProviderConfigs = null;
    protected static $callbacks = [];

    public static function setProviderConfigs($configs) {
        self::$userProviderConfig = $configs;
    }

    public static function getUserProviderConfigs($configs) {
        return self::$userProviderConfig ?? $config;
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
        $provider = Config::get('auth.api.provider');
        $userProviderConfigs = Config::get('auth.providers.' . $provider);
        $userProvider = Auth::createUserProvider(\Zento\Passport\Passport::getUserProviderConfigs($userProviderConfigs));

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
