<?php

namespace Zento\Passport;

class Passport
{
    protected static $callbacks = [];
    public static function registerPostAuthcateHook(\Closure $callback) {
        self::$callbacks[] = $callback;
    }

    public function callPostAuthcateHooks($user, $request) {
        foreach(self::$callbacks as $callback) {
            $callback($user, $request);
        }
    }
}
